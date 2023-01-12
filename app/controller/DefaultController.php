<?php
class DefaultController extends Controller
{
    public function index()
    {
        $kecamatan = $this->getTotalByTable('kecamatan');
        $tahapan = $this->getTotalByTable('tahapan');
        $calon = $this->getTotalByTable('calon');
        // get session
        $this->template = 'main';
        $this->title = 'Home';
        $this->render('home',  compact('kecamatan', 'tahapan', 'calon'));
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

    private function getTotalByTable($table_name)
    {
        $select = query_one("select count(*) as total from $table_name");
        $result = is_null($select) ? 0 : $select['total'];
        return $result;
    }
}
