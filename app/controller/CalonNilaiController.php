<?php
class CalonNilaiController extends Controller
{
    public function __construct()
    {
        $this->template = 'main';
        $this->model('CalonNilai', 'model');
    }

    public function index()
    {
        $tahapans = $this->model->tahapanWithNilai();
        $kecamatans = query_array('SELECT * from kecamatan');
        $this->title = 'Calon Nilai';
        $this->render('calon_nilai', compact('kecamatans', 'tahapans'));
    }

    public function calon_list()
    {
        $tahapans = $this->model->tahapanWithNilai();
        $calons = $this->model->listCalonNilai();

        $this->output_json(compact('tahapans', 'calons'));
    }

    public function calon_nilai()
    {
        $id = get('id', false);
        $calon = query_one("SELECT calon.*, kecamatan.nama as kecamatan from calon join kecamatan on calon.kecamatan_id = kecamatan.id where calon.id = '$id'");
        $nilais = $this->model->calonNilai($id);
        $tahapans = $this->model->tahapanWithNilai();
        $this->output_json(compact('calon', 'nilais', 'tahapans'));
    }

    public function simpan()
    {
        $calon_id = post('calon_id');
        $tahapans = post('tahapans');
        $this->model->simpan($calon_id, $tahapans);
        $this->output_json(['success' => true]);
    }
}
