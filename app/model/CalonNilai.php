<?php
class CalonNilai extends Model
{
    public function listCalonNilai()
    {
        $calonNilais = [];

        // get list calon
        $calons = query_array("SELECT calon.*, kecamatan.nama as kecamatan from calon join kecamatan on calon.kecamatan_id = kecamatan.id");

        foreach ($calons as $calon) {
            $calon['tahapans'] = $this->calonNilai($calon['id']);
            $calonNilais[] = $calon;
        }
        return $calonNilais;
    }

    public function calonNilai($calon_id)
    {
        $results = [];
        // get list tahapan
        $tahapans = query_array("SELECT * from tahapan order by urutan");
        foreach ($tahapans as $tahapan) {
            $nilai = query_one("SELECT tahapan_nilai.* from calon_tahapan_nilai 
            left join tahapan_nilai on calon_tahapan_nilai.tahapan_nilai_id = tahapan_nilai.id
            where 
            calon_tahapan_nilai.tahapan_id = '$tahapan[id]' and calon_tahapan_nilai.calon_id = '$calon_id'");
            $tahapan['nilai'] = $nilai;
            $results[] = $tahapan;
        }

        return $results;
    }

    public function tahapanWithNilai()
    {
        $results = [];
        $tahapans = query_array("SELECT * from tahapan order by urutan");

        foreach ($tahapans as $tahapan) {
            $nilai = query_array("SELECT * from tahapan_nilai where tahapan_id = '$tahapan[id]' order by urutan");
            $tahapan['nilais'] = $nilai;
            $results[] = $tahapan;
        }
        return $results;
    }

    public function simpan($calon_id, $tahapans)
    {

        query_build('START TRANSACTION;');
        // hapus semua nilai by calon
        $hapus = query_build("DELETE FROM calon_tahapan_nilai WHERE `calon_id` = '$calon_id'");

        // simpan semua nilai by calon
        foreach ($tahapans ?? [] as $tahapan_id => $tahapan_nilai_id) {
            if (!in_array($tahapan_nilai_id, ['', null])) {
                query_build("INSERT INTO `calon_tahapan_nilai` 
                (`id`, `calon_id`, `tahapan_id`, `tahapan_nilai_id`) 
                VALUES 
                (NULL, $calon_id, $tahapan_id, $tahapan_nilai_id)");
            }
        }

        query_build('COMMIT;');

        return $hapus;
    }
}
