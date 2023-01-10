<?php
class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model('Login', 'model');
    }

    public function index()
    {
        $this->template = 'auth';
        $this->title = 'Login';
        $this->render('login');
    }

    public function doLogin()
    {
        try {
            $email = post('email');
            $password = post('password');

            // amankan data yang diambil
            $email = is_null($email) ? '' : mrq($email);
            $password = is_null($password) ? '' : mrq($password);

            $sql = "SELECT * from admin where email = '$email'";

            $cek_email = query_one($sql);

            if (is_null($cek_email)) {
                $this->output_json(['message' => 'Email tidak terdaftar'], 400);
            }

            // if ($cek_email['status'] != 1) {
            //     $this->output_json(['message' => 'Akun anda di nonaktifkan silahkan hubungi admin'], 400);
            // }

            if (password_verify($password, $cek_email['password'])) {
                unset($cek_email['password']);
                // set session
                $cek_email['role'] = 'staf';
                $_SESSION['auth'] = $cek_email;
                $this->output_json($cek_email);
            } else {
                $this->output_json(['message' => 'Password Yang anda masukan salah'], 400);
            }
        } catch (\Exception  $e) {
            $this->output_json(['message' => 'Server Error', 'error_message' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        $klinik_kode = klinik_kode();
        session_unset();
        session_destroy();
        $route = route('login', ['kode' => $klinik_kode]);
        header("Location: $route");
    }
}
