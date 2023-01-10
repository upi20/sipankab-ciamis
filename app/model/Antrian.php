<?php
class Antrian extends Model
{
    public function pasien_select2($search)
    {
        $klinik_kode = klinik_kode();
        // where pasien belum terdaftar pada hari ini dan dipanggil is null dan antrian belum dibatalkan

        $sql = <<<SQL
            SELECT concat(person.nama, ' | ', person.alamat) as text, pasien.pasien_mr as id from t_person as person
            join t_pasien as pasien on person.person_id = pasien.person_id
            join p_klinik_pasien as klinik_pasien on pasien.pasien_mr = klinik_pasien.pasien_mr
            where 

            -- klinik
            klinik_pasien.klinik_kode = '$klinik_kode'
            
            -- psien tidak dalam antrian < 3 selesai
            and ( pasien.pasien_mr not in ( 
                select antrian.pasien_mr from t_klinik_antrian as antrian 
                where antrian.klinik_kode = '$klinik_kode' 
                and (antrian.status < 3 and date(antrian.tanggal) = date(now())) ) )
            
            -- where like
            and ( person.nama like '%$search%' or person.alamat like '%$search%' or pasien.pasien_mr like '%$search%' )
            
            -- order
            order by person.nama limit 20
        SQL;
        $result = $this->query_array($sql);
        return $result;
    }

    public function datatable($draw = null, $length = null, $start = null, $search = null, $order = null, $filter = null, $count = false)
    {
        // search
        $query_search = '';
        $klinik_kode = klinik_kode();

        $search = mysqli_real_escape_string(conn(), $search);
        if (!in_array($search, ['', null])) {
            $query_search = <<<SQL
                (
                    (DATE_FORMAT(antrian.tanggal, '%d-%b-%Y %H:%i:%s')) like '%$search%' or
                    person.nama like '%$search%' or
                    person.alamat like '%$search%' or
                    antrian.no_antrian like '%$search%'
                )
            SQL;
        }

        $filter_query = '';
        // filter status
        if (isset($filter['status']) ? ($filter['status'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $status = $filter['status'];

            // status antrian
            $filter_query .= " antrian.status = $status";
        }

        if (isset($filter['tanggal']) ? ($filter['tanggal'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $tanggal = $filter['tanggal'];

            // filter tanggal
            $filter_query .= " ((date(antrian.tanggal) = '$tanggal') || (date(antrian.dipanggil) = '$tanggal'))";
        }

        if (isset($filter['ktp_ada']) ? ($filter['ktp_ada'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $ktp_ada = $filter['ktp_ada'];

            // filter ktp
            $filter_query .= " if(person.foto_ktp is null,0,1) = '$ktp_ada'";
        }

        if (isset($filter['dipanggil']) ? ($filter['dipanggil'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $dipanggil = $filter['dipanggil'];
            $filter_query .= " if(antrian.dipanggil is null, 'Tidak', 'Ya') = '$dipanggil'";
        }

        // klinik where and
        $klinik_and = ($query_search != '' || $filter_query != '') ? ' and ' : '';

        // order custom
        $order_by = '';
        if ($order['order'] != null) {
            $columns = $order['columns'];
            $dir = $order['order'][0]['dir'];
            $order = $order['order'][0]['column'];
            $columns = $columns[$order];

            $order_colum = $columns['data'];
            if ($order_colum == 'status') $order_colum = 'antrian.status';
            if ($order_colum == 'pasien_nama') $order_colum = 'person.nama';
            if ($order_colum == 'tanggal_str') $order_colum = 'antrian.tnggal';
            if ($order_colum == 'pasien_alamat') $order_colum = 'person.alamat';
            $order_by = "order by $order_colum $dir";
        }

        $query_from_where = <<<SQL
            from t_klinik_antrian as antrian 
            join t_pasien as pasien on antrian.pasien_mr = pasien.pasien_mr
            join t_person as person on person.person_id = pasien.person_id
            where antrian.klinik_kode = '$klinik_kode'
            $klinik_and $query_search $filter_query $order_by
        SQL;

        if ($count) {
            $result = $this->query_one("SELECT count(*) as aggregate $query_from_where limit 1");
            return isset($result['aggregate']) ? $result['aggregate'] : 0;
        } else {
            return $this->query_array("SELECT antrian.*, 
            if(person.foto_ktp is null,0,1) as ktp_ada,
            person.foto_ktp,
            DATE_FORMAT(antrian.tanggal, '%W, %d %M %Y %H:%i:%s') as tanggal_full,
            person.nama as pasien_nama,
            pasien.pasien_mr,
            person.alamat as pasien_alamat,
            (DATE_FORMAT(antrian.tanggal, '%d-%b-%Y %H:%i:%s')) as tanggal_str,
            (DATE_FORMAT(antrian.dipanggil, '%d-%b-%Y %H:%i:%s')) as dipanggil_str
            $query_from_where limit $length offset $start");
        }
    }

    public function get_no_antrian()
    {
        $klinik_kode = klinik_kode();
        // get nomor ter tinggi hari ini
        $no_antrian = $this->query_one("SELECT (ifnull(max(no_antrian) ,0)+1) as antrian 
                from t_klinik_antrian 
                where klinik_kode = '$klinik_kode' and date(tanggal) = date(now()) limit 1");
        $no_antrian = isset($no_antrian['antrian']) ? $no_antrian['antrian'] : 1;

        return $no_antrian;
    }

    public function tambah($pasien_mr, $dokter_id)
    {
        $klinik_kode = klinik_kode();
        // get nomor ter tinggi hari ini
        $no_antrian = $this->get_no_antrian();

        // simpan
        $sql = <<<SQL
            INSERT INTO `t_klinik_antrian` 
            (`antrian_id`,  `klinik_kode`,  `pasien_mr`, `dokter_id`,  `tanggal`,  `no_antrian`, `status`) 
            VALUES 
            (NULL, '$klinik_kode', '$pasien_mr', '$dokter_id', now(), '$no_antrian', 1);
        SQL;

        mysqli_query(conn(), $sql);
        return mysqli_affected_rows(conn());
    }

    public function dipanggil($antrian_id)
    {
        $klinik_kode = klinik_kode();
        $this->query("UPDATE `t_klinik_antrian` SET `dipanggil` = now() WHERE `antrian_id` = '$antrian_id' and `klinik_kode` = '$klinik_kode'");
        return mysqli_affected_rows(conn());
    }

    public function set_status($antrian_id, $status)
    {
        $klinik_kode = klinik_kode();
        $this->query("UPDATE `t_klinik_antrian` SET `status` = '$status' WHERE `antrian_id` = '$antrian_id' and `klinik_kode` = '$klinik_kode'");
        return mysqli_affected_rows(conn());
    }

    public function cetak_mr($antrian_id)
    {
        $klinik_kode = klinik_kode();
        $query = <<<SQL
                select 
                    antrian.antrian_id,
                    person.nama,
                    DATE_FORMAT(antrian.tanggal, '%W, %d %M %Y') as tanggal,
                    (DATE_FORMAT(FROM_DAYS(DATEDIFF(date(now()), person.tanggal_lahir)), '%Y') + 0) as umur,
                    person.tanggal_lahir,
                    if(person.jenis_kelamin = 'l', 'Laki-Laki', if(person.jenis_kelamin = 'p', 'Perempuan', '') ) as jenis_kelamin,
                    person.alamat, 
                    pasien.pasien_mr
                from t_klinik_antrian as antrian 
                join t_pasien as pasien on antrian.pasien_mr = pasien.pasien_mr
                join t_person as person on person.person_id = pasien.person_id
                where antrian.antrian_id = '$antrian_id' and antrian.klinik_kode = '$klinik_kode' limit 1
            SQL;
        $get = $this->query_one($query);
        return $get;
    }

    public function insert_mr($antrian_id)
    {
        $antrian = query_one("SELECT pasien_mr, dokter_id, klinik_kode from t_klinik_antrian where antrian_id = '$antrian_id' limit 1");

        if (is_null($antrian)) {
            return false;
        }
        $pasien_mr = $antrian['pasien_mr'];
        $dokter_id = $antrian['dokter_id'];
        $klinik_kode = $antrian['klinik_kode'];

        $result = query_build("INSERT INTO `t_pasien_hr` (`hr_id`, `klinik_kode`, `pasien_mr`, `dokter_id`, `antrian_id`, `tanggal`) 
        VALUES 
        (NULL, '$klinik_kode', '$pasien_mr', '$dokter_id', '$antrian_id', now())");
        return $result;
    }

    public function list_dokter()
    {
        $klinik_kode = klinik_kode();
        $dokters = query_array("SELECT dokter.dokter_id, person.nama FROM p_klinik_dokter as p_dokter 
        join t_dokter as dokter on dokter.dokter_id = p_dokter.dokter_id
        join t_person as person on person.person_id = dokter.person_id
        where p_dokter.klinik_kode = '$klinik_kode'");

        return $dokters;
    }
}
