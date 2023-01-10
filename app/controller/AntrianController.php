<?php
class AntrianController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->template = 'main';
        $this->model('Antrian', 'model');
    }

    public function index()
    {
        $dokters = $this->model->list_dokter();
        $jml_dokter = is_null($dokters) ? 0 : count($dokters);
        $this->title = 'Antrian';
        $this->render('antrian', compact('dokters', 'jml_dokter'));
    }

    public function not_found()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->output_json(['message' => 'Route not found'], 404);
        } else {
            $this->template = null;
            $this->title = 'Page Not Found';
            $this->render('404');
        }
    }

    public function pasien_select2()
    {
        $search = get('search', false);
        $result = $this->model->pasien_select2($search);
        $this->output_json(['results' => $result]);
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

        $antrian_terbaru = $this->model->get_no_antrian();
        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $search, 'data' => $data, 'antrian_terbaru' => $antrian_terbaru]);
    }

    public function tambah()
    {
        $pasien_mr = post('pasien_mr');
        $dokter_id = post('dokter_id');
        $result = $this->model->tambah($pasien_mr, $dokter_id);
        $antrian_terbaru = $this->model->get_no_antrian();
        $this->output_json(['result' => $result, 'antrian_terbaru' => $antrian_terbaru]);
    }

    public function dipanggil()
    {
        $antrian_id = post('antrian_id');
        $result = $this->model->dipanggil($antrian_id);
        $antrian_terbaru = $this->model->get_no_antrian();
        $this->output_json(['result' => $result, 'antrian_terbaru' => $antrian_terbaru]);
    }

    public function masuk()
    {
        $antrian_id = post('antrian_id');
        $status_batal = 4;
        $status_selesai = 3;
        $status_masuk = 2;

        $result = $this->model->set_status($antrian_id, $status_masuk);
        $result = true;

        // setelah set status kemudian insert mr kosong
        $this->model->insert_mr($antrian_id);

        $antrian_terbaru = $this->model->get_no_antrian();
        $this->output_json(['result' => $result, 'antrian_terbaru' => $antrian_terbaru]);
    }

    public function batalkan()
    {
        $antrian_id = post('antrian_id');
        $status_batal = 4;
        $status_selesai = 3;
        $status_masuk = 2;

        $result = $this->model->set_status($antrian_id, $status_batal);
        $antrian_terbaru = $this->model->get_no_antrian();
        $this->output_json(['result' => $result, 'antrian_terbaru' => $antrian_terbaru]);
    }

    public function cetak_mr()
    {
        $id = get('id', false);
        $title = 'Print Health Record';
        $this->template = 'non';
        $mr = $this->model->cetak_mr($id);
        if (is_null($mr)) {
            $this->render('not_found');
            die;
        }
        $this->render('antrian_cetak_mr', compact('mr', 'title'));
    }

    public function print()
    {
        $this->template = null;
        $this->render('antrian_print');
    }
}
