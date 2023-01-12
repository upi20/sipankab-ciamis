<?php
class Calon extends Model
{
    public function create($kecamatan_id, $nomor_pendaftaran, $nama, $jenis_kelamin, $tanggal_lahir, $nomor_telepon)
    {
        $kecamatan_id = value_sql_null($kecamatan_id);
        $nomor_pendaftaran = value_sql_null($nomor_pendaftaran);
        $nama = value_sql_null($nama);
        $jenis_kelamin = value_sql_null($jenis_kelamin);
        $tanggal_lahir = value_sql_null($tanggal_lahir);
        $nomor_telepon = value_sql_null($nomor_telepon);

        query_build("INSERT INTO `calon` 
            ( `kecamatan_id`, `nomor_pendaftaran`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `nomor_telepon` ) 
                VALUES 
            ( $kecamatan_id, $nomor_pendaftaran, $nama, $jenis_kelamin, $tanggal_lahir, $nomor_telepon)");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function update($id, $kecamatan_id, $nomor_pendaftaran, $nama, $jenis_kelamin, $tanggal_lahir, $nomor_telepon)
    {
        $kecamatan_id = value_sql_null($kecamatan_id);
        $nomor_pendaftaran = value_sql_null($nomor_pendaftaran);
        $nama = value_sql_null($nama);
        $jenis_kelamin = value_sql_null($jenis_kelamin);
        $tanggal_lahir = value_sql_null($tanggal_lahir);
        $nomor_telepon = value_sql_null($nomor_telepon);

        query_build("UPDATE `calon` SET 
            kecamatan_id = $kecamatan_id,
            nomor_pendaftaran = $nomor_pendaftaran,
            nama = $nama,
            jenis_kelamin = $jenis_kelamin,
            tanggal_lahir = $tanggal_lahir,
            nomor_telepon = $nomor_telepon
         WHERE id = '$id'");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function find($id)
    {
        $staf = query_one("SELECT * from `calon` where id = '$id' limit 1");
        return $staf;
    }

    public function delete($id)
    {
        $result = query_build("DELETE FROM calon where id='$id'");
        return $result;
    }

    public function datatable($draw = null, $length = null, $start = null, $search = null, $order = null, $filter = null, $count = false)
    {
        $query_search = '';
        $search = mysqli_real_escape_string(conn(), $search);
        if (!in_array($search, ['', null])) {
            $query_search = <<<SQL
                (
                    calon.kecamatan_id like '%$search%' or 
                    calon.nomor_pendaftaran like '%$search%' or 
                    calon.nama like '%$search%' or 
                    calon.jenis_kelamin like '%$search%' or 
                    calon.tanggal_lahir like '%$search%' or 
                    calon.nomor_telepon like '%$search%' or 
                    kecamatan.nama like '%$search%'
                )
            SQL;
        }

        $filter_query = '';
        // filter 
        if (isset($filter['jenis_kelamin']) ? ($filter['jenis_kelamin'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $jenis_kelamin = $filter['jenis_kelamin'];
            $filter_query .= " calon.jenis_kelamin = '$jenis_kelamin'";
        }

        if (isset($filter['kecamatan_id']) ? ($filter['kecamatan_id'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $kecamatan_id = $filter['kecamatan_id'];
            $filter_query .= " calon.kecamatan_id = $kecamatan_id";
        }

        // klinik where and
        $query_where = ($query_search != '' || $filter_query != '') ? ' where ' : '';
        // order custom
        $order_by = '';
        if ($order['order'] != null) {
            $columns = $order['columns'];
            $dir = $order['order'][0]['dir'];
            $order = $order['order'][0]['column'];
            $columns = $columns[$order];

            $order_colum = $columns['data'];
            if ($order_colum == 'kecamatan') $order_colum = 'kecamatan.nama';
            $order_by = "order by $order_colum $dir";
        }
        // order default
        else {
            $order_by = "order by calon.nama asc";
        }

        $query_from_where = <<<SQL
            from calon
            left join kecamatan on kecamatan.id = calon.kecamatan_id 
            $query_where $query_search $filter_query $order_by
        SQL;

        if ($count) {
            $result = $this->query_one("SELECT count(*) as aggregate $query_from_where");
            return isset($result['aggregate']) ? $result['aggregate'] : 0;
        } else {
            $sql = "SELECT calon.*, kecamatan.nama as kecamatan $query_from_where limit $length offset $start";
            return $this->query_array($sql);
        }
    }
}
