<?php
class KecamatanController extends Controller
{
    public function __construct()
    {
        $this->template = 'main';
        $this->model('Kecamatan', 'model');
    }

    public function index()
    {
        $this->title = 'Kecamatan';
        $this->render('kecamatan');
    }

    public function find()
    {
        $id = get('id', false);
        $result = $this->model->find($id);
        $this->output_json($result);
    }

    public function insert()
    {
        $result = $this->model->create(post('nama'));
        $code = $result['code'];
        $this->output_json($result, $code);
    }

    public function update()
    {
        $result = $this->model->update(post('id'), post('nama'));
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
