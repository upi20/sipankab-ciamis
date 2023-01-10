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
        $id = $_SESSION['auth']['id'];
        $person = query_one("SELECT * from admin where id = '$id' limit 1");
        $this->title = 'Profil';
        $this->render('profile', compact('person'));
    }

    public function simpan()
    {
        $id = $_SESSION['auth']['id'];

        $email = value_sql_null(post('email'));
        $nama = value_sql_null(post('nama'));

        // update person
        query_build("UPDATE `admin` SET 
        nama = $nama,
        email = $email
        WHERE id = '$id'");

        $this->output_json([
            'message' => 'Data Berhasil disimpan'
        ]);
    }
}
