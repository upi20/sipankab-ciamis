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

        // amankan data yang diambil
        $email = is_null($email) ? '' : mrq($email);
        $password = is_null($password) ? '' : mrq($password);

        $sql = "SELECT * from admin where email = '$email'";

        $cek_email = query_one($sql);

        if (is_null($cek_email)) {
            $this->output_json(['message' => 'User Tidak ditemukan'], 400);
        }

        if (password_verify($password, $cek_email['password'])) {
            // ganti password
            $new_password = post('new_password');
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $id = $cek_email['id'];

            try {
                query_build("UPDATE `admin` SET `password` = '$new_password' WHERE `id` = '$id'");
            } catch (\Exception  $e) {
                $this->output_json(['message' => 'Server Error', 'error_message' => $e->getMessage()], 500);
            }

            $this->output_json(true);
        } else {
            $this->output_json(['message' => 'Password Lama Yang anda masukan salah'], 400);
        }
    }
}
