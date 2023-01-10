<?php
class CalonController extends Controller
{
    public function __construct()
    {
        $this->template = 'main';
        $this->model('Calon', 'model');
    }

    public function index()
    {
        $kecamatans = query_array('SELECT * from kecamatan');
        $this->title = 'Calon';
        $this->render('calon', compact('kecamatans'));
    }

    public function find()
    {
        $id = get('id', false);
        $result = $this->model->find($id);
        $this->output_json($result);
    }

    public function insert()
    {
        $kecamatan_id = post('kecamatan_id');
        $nomor_pendaftaran = post('nomor_pendaftaran');
        $nama = post('nama');
        $jenis_kelamin = post('jenis_kelamin');
        $alamat = post('alamat');
        $nomor_telepon = post('nomor_telepon');

        $result = $this->model->create($kecamatan_id, $nomor_pendaftaran, $nama, $jenis_kelamin, $alamat, $nomor_telepon);
        $code = $result['code'];
        $this->output_json($result, $code);
    }

    public function update()
    {
        $id = post('id');
        $kecamatan_id = post('kecamatan_id');
        $nomor_pendaftaran = post('nomor_pendaftaran');
        $nama = post('nama');
        $jenis_kelamin = post('jenis_kelamin');
        $alamat = post('alamat');
        $nomor_telepon = post('nomor_telepon');
        $result = $this->model->update($id, $kecamatan_id, $nomor_pendaftaran, $nama, $jenis_kelamin, $alamat, $nomor_telepon);
        $code = $result['code'];
        $this->output_json($result, $code);
    }

    public function delete()
    {
        $id = post('id');
        $result = $this->model->delete($id);
        $this->output_json($result);
    }

    public function datatable()
    {
        $order = [
            'order' => post('order'),
            'columns' => post('columns')
        ];

        $start = post('start');
        $draw = post('draw');
        $draw = $draw == null ? 1 : $draw;
        $length = post('length');
        $cari = post('search');

        if (isset($cari['value'])) {
            $search = $cari['value'];
        } else {
            $search = null;
        }

        $filter = post('filter');

        $data = $this->model->datatable($draw, $length, $start, $search, $order, $filter);
        $count = $this->model->datatable(null, null, null, $search, $order, null, true);

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $search, 'data' => $data]);
    }
}
