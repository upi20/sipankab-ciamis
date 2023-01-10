<?php

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * halaman utama
     * @return [void]
     */
    public function index()
    {
        $person_id = $_SESSION['auth']['person_id'];
        $person = query_one("SELECT person.*, user.email FROM t_person as person join t_user as user on user.person_id = person.person_id where person.person_id = '$person_id' limit 1");
        $this->title = 'Profil';
        $this->render('profile', compact('person'));
    }

    public function simpan()
    {
        $person_id = $_SESSION['auth']['person_id'];
        $nik = value_sql_null(post('nik'));
        $email = value_sql_null(post('email'));

        $nama = value_sql_null(post('nama'));
        $alamat = value_sql_null(post('alamat'));
        $tempat_lahir = value_sql_null(post('tempat_lahir'));
        $tanggal_lahir = value_sql_null(post('tanggal_lahir'));
        $jenis_kelamin = value_sql_null(post('jenis_kelamin'));

        query_build('START TRANSACTION;');
        // cek nik
        $person = query_one("SELECT person_id, foto_ktp from t_person where nik = $nik and person_id <> '$person_id'");
        if ($person != null) {
            $this->output_json(['message' => 'NIK Sudah Digunakan'], 400);
        }

        // cek email
        if (post('email') != $_SESSION['auth']['email']) {
            $cek_email = query_one("SELECT email from t_user where email=$email");
            if ($cek_email != null) {
                $this->output_json(['message' => 'Email Sudah Digunakan'], 400);
            }

            // ganti email
            query_build("UPDATE `t_user` SET 
            email = $email
            WHERE person_id = '$person_id'");

            // update session
            $_SESSION['auth']['email'] = post('email');
        }

        $post_nama = post('nama');
        $date = date('YmdHis');
        $name = slugify("ktp_{$date}_{$post_nama}");
        $foto_result = base64_upload_file('ktp', $name, post('foto_ktp_ext'), post('foto_ktp'));

        // upload foto ktp
        $old_foto_ktp = post('old_foto_ktp');
        $foto_ktp_up = $old_foto_ktp;
        if ($foto_result['result']) {
            $foto_ktp_up = $foto_result['path'];
            // delete current file
            delete_file($old_foto_ktp);
        }
        $foto_ktp = value_sql_null($foto_ktp_up);

        // update person
        query_build("UPDATE `t_person` SET 
        nik = $nik,
        nama = $nama,
        alamat = $alamat,
        tempat_lahir = $tempat_lahir,
        tanggal_lahir = $tanggal_lahir,
        jenis_kelamin = $jenis_kelamin,
        foto_ktp = $foto_ktp
        WHERE person_id = '$person_id'");

        // update session
        $_SESSION['auth']['nama'] = post('nama');
        query_build('COMMIT;');
        $this->output_json([
            'message' => 'Data Berhasil disimpan',
            'foto_ktp' => asset($foto_ktp_up),
            'old_foto_ktp' => $foto_ktp_up,
        ]);
    }
}
