<?php
class DefaultController extends Controller
{
    public function index()
    {
        // get session
        $this->template = 'main';
        $this->title = 'Home';
        $this->render('home');
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
}
