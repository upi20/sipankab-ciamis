<?php
class Pasien extends Model
{
    public function upload_ktp($person_id, $foto_ktp)
    {
        // set sql support
        $foto_ktp = value_sql_null($foto_ktp);
        mysqli_query(conn(), "UPDATE `t_person` SET 
        `t_person`.`foto_ktp` = $foto_ktp
        WHERE `t_person`.`person_id` = '$person_id'");
        return mysqli_affected_rows(conn());
    }

    public function pasien_baru($nama, $alamat, $foto_ktp)
    {

        // set sql support
        $nama = value_sql_null($nama);
        $alamat = value_sql_null($alamat);
        $foto_ktp = value_sql_null($foto_ktp);

        query_build('START TRANSACTION;');

        // insert person
        query_build("INSERT INTO `t_person` 
        (`person_id`, `nama`, `alamat`, `foto_ktp` ) 
        VALUES
        (NULL, $nama, $alamat, $foto_ktp)");

        // insert pasien
        $last_id = $this->query_one("SELECT LAST_INSERT_ID() as person_id");
        $person_id = $last_id['person_id'];
        $pasien_mr = $this->no_rm_baru();

        query_build("INSERT INTO `t_pasien` 
        (`pasien_mr`, `person_id`, `tanggal_daftar` ) 
        VALUES
        ('$pasien_mr', '$person_id', date(now()))");

        // insert klinik pasien
        $klinik_kode = klinik_kode();
        query_build("INSERT INTO `p_klinik_pasien` 
        (`klinik_kode`, `pasien_mr`) 
        VALUES
        ('$klinik_kode', '$pasien_mr')");

        query_build('COMMIT;');
        return $pasien_mr;
    }

    private function no_rm_baru()
    {
        $generator = new StringGenerator();
        $max_loop = 300;
        $curr_loop = 1;
        $loop = true;
        $result = null;
        while ($loop && $curr_loop < $max_loop) {
            $rand = $generator->randomAlnum(8, true);
            $check = query_one("SELECT * FROM t_pasien where pasien_mr = '$rand'");
            if (is_null($check)) {
                return $rand;
            }
            $curr_loop++;
        }
        return $result;
    }
}
