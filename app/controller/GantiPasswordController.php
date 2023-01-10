<?php

class GantiPasswordController extends Controller
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
        $this->title = 'Ganti Password';
        $this->render('ganti_password');
    }

    public function simpan()
    {
        $email = $_SESSION['auth']['email'];
        $password = post('current_password');
        $kode = klinik_kode();

        // amankan data yang diambil
        $email = is_null($email) ? '' : mrq($email);
        $password = is_null($password) ? '' : mrq($password);

        $sql = "SELECT user.user_id, user.password from t_user as user
        join t_person as person on user.person_id = person.person_id
        join t_dokter as dokter on dokter.person_id = person.person_id
        join p_klinik_dokter as p_dokter on dokter.dokter_id = p_dokter.dokter_id
        where p_dokter.klinik_kode = '$kode' and user.email = '$email'";

        $cek_email = $this->model->query_one($sql);

        if (is_null($cek_email)) {
            $this->output_json(['message' => 'User Tidak ditemukan'], 400);
        }

        if (password_verify($password, $cek_email['password'])) {
            // ganti password
            $new_password = post('new_password');
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $user_id = $cek_email['user_id'];

            try {
                query_build("UPDATE `t_user` SET `password` = '$new_password' WHERE `user_id` = '$user_id'");
            } catch (\Exception  $e) {
                $this->output_json(['message' => 'Server Error', 'error_message' => $e->getMessage()], 500);
            }

            $this->output_json(true);
        } else {
            $this->output_json(['message' => 'Password Lama Yang anda masukan salah'], 400);
        }
    }
}
