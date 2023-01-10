<?php
class PasienController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->template = 'main';
        $this->model('Pasien', 'model');
        $this->model('Antrian', 'antrian');
    }

    public function upload_ktp()
    {
        // foto ktp
        $foto_ktp = null;
        $pasien_mr = post('pasien_mr');

        // get person
        $person = query_one("SELECT person_id from t_pasien where pasien_mr = '$pasien_mr'");

        if (is_null($person)) {
            $this->output_json(['message' => 'No Health Record Invalid'], 400);
        }
        $person_id = $person['person_id'];

        $person = query_one("SELECT person_id,nama from t_person where person_id = '$person_id'");
        $post_nama = $person['nama'];
        $date = date('YmdHis');
        $name = slugify("ktp_{$date}_{$post_nama}");

        $foto_result = base64_upload_file('ktp', $name, post('foto_ktp_ext'), post('foto_ktp'));

        if ($foto_result['result']) {
            $foto_ktp = $foto_result['path'];
        }

        $result = $this->model->upload_ktp($person_id, $foto_ktp);
        $this->output_json($result);
    }

    public function insert()
    {
        $nama = post('nama');
        $alamat = post('alamat');
        $foto_ktp = null;
        $post_nama =  $nama;
        $date = date('YmdHis');
        $name = slugify("ktp_{$date}_{$post_nama}");

        $foto_result = base64_upload_file('ktp', $name, post('foto_ktp_ext'), post('foto_ktp'));

        if ($foto_result['result']) {
            $foto_ktp = $foto_result['path'];
        }

        $result = $this->model->pasien_baru($nama, $alamat, $foto_ktp);
        $this->output_json($result);
    }
}
