<?php
class TahapanController extends Controller
{
    public function __construct()
    {
        $this->template = 'main';
        $this->model('Tahapan', 'model');
    }

    public function index()
    {
        $this->title = 'Tahapan';
        $this->render('tahapan');
    }

    public function find()
    {
        $id = get('id', false);
        $result = $this->model->find($id);
        $this->output_json($result);
    }

    public function insert()
    {
        $result = $this->model->create(post('nama'), post('urutan'));
        $code = $result['code'];
        $this->output_json($result, $code);
    }

    public function update()
    {
        $result = $this->model->update(post('id'), post('nama'), post('urutan'));
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

    // tahapan nilai
    public function nilai_index()
    {
        $this->title = 'Nilai Dari Tahapan';
        $id = get('id', false);

        $tahapan = query_one("SELECT * from tahapan where id = '$id'");
        if (is_null($tahapan)) {
            $this->page_not_found();
        } else {
            $this->render('tahapan_nilai', compact('tahapan'));
        }
    }

    public function nilai_find()
    {
        $id = get('id', false);
        $result = $this->model->nilai_find($id);
        $this->output_json($result);
    }

    public function nilai_insert()
    {
        $tahapan_id = post('tahapan_id');
        $urutan = post('urutan');
        $nilai = post('nilai');
        $nilai_nama = post('nilai_nama');
        $nilai_dari = post('nilai_dari');
        $nilai_sampai = post('nilai_sampai');

        $result = $this->model->nilai_create($tahapan_id, $urutan, $nilai, $nilai_nama, $nilai_dari, $nilai_sampai);
        $code = $result['code'];
        $this->output_json($result, $code);
    }

    public function nilai_update()
    {
        $id = post('id');
        $tahapan_id = post('tahapan_id');
        $urutan = post('urutan');
        $nilai = post('nilai');
        $nilai_nama = post('nilai_nama');
        $nilai_dari = post('nilai_dari');
        $nilai_sampai = post('nilai_sampai');

        $result = $this->model->nilai_update($id, $tahapan_id, $urutan, $nilai, $nilai_nama, $nilai_dari, $nilai_sampai);
        $code = $result['code'];
        $this->output_json($result, $code);
    }

    public function nilai_delete()
    {
        $id = post('id');
        $result = $this->model->nilai_delete($id);
        $this->output_json($result);
    }

    public function nilai_datatable()
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

        $data = $this->model->nilai_datatable($draw, $length, $start, $search, $order, $filter);
        $count = $this->model->nilai_datatable(null, null, null, $search, $order, null, true);

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $search, 'data' => $data]);
    }
}
