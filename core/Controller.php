<?php

/**
 * Core Controller
 */
class Controller
{
    protected $title;
    protected $template = 'main';

    protected $klinik;
    protected $ruangan;
    public function __construct()
    {
        $this->klinik = klinik_kode();
    }

    protected function render($view, $data = null)
    {
        global $dir;
        $view_folder = $dir . '/view';
        $view_path = "$view_folder/$view.php";
        if (file_exists($view_path)) {
            $title = $this->title;
            if (is_array($data)) {
                extract($data);
            }

            $template_header = "$view_folder/template/$this->template/header.php";
            $template_menu = "$view_folder/template/$this->template/menu.php";
            $template_footer = "$view_folder/template/$this->template/footer.php";

            if (file_exists($template_header)) require_once $template_header;
            if (file_exists($template_menu)) require_once $template_menu;
            require_once $view_path;
            if (file_exists($template_footer)) require_once $template_footer;
        } else {
            $title = '404 Not found';
            require_once  $dir . "/view/404.php";
        }
    }

    /**
     * @param $model
     * @param string|null $alias
     * Untuk memanggil model
     * @return void
     */
    protected function model($model, $alias = null)
    {
        global $dir;
        $view_path = $dir . "/model/$model.php";
        if (file_exists($view_path)) {
            require_once $view_path;
            $model_name = $alias ?? $model;
            $this->$model_name = new $model();
        }
    }

    /**
     * @param $data
     * @param int|null $code
     * Untuk membuat output dengan tipe data json
     * @return void
     */
    protected function output_json($data, $code = null)
    {
        header('Content-Type: application/json');
        $code = $code == null ? 200 : $code;
        http_response_code($code);
        echo (json_encode($data));
        die;
    }

    public function upload_foto($name, $directory)
    {
        global $dir;
        if (!isset($_FILES[$name])) {
            return [
                'message' => "File ($name) not found.",
                'status' => false,
                'data' => null,
            ];
        }
        // Get reference to uploaded image
        $image_file = $_FILES[$name];

        // Exit if is not a valid image file
        $image_type = exif_imagetype($image_file["tmp_name"]);
        if (!$image_type) {
            return [
                'message' => 'Uploaded file is not an image',
                'status' => false,
                'data' => null,
            ];
        }
        $code = StringGenerator::randomAlnum(4);
        $date = date("ymdhis");
        $file = "assets/upload/$directory/$date" . $code . $image_file["name"];

        // Move the temp image file to the images/ directory
        $result = move_uploaded_file(
            // Temp image location
            $image_file["tmp_name"],

            // New image location
            $dir . "/../../$file"
        );

        if ($result) {
            return [
                'message' => 'Success',
                'status' => true,
                'data' => $file,
            ];
        } else {
            return [
                'message' => 'System error',
                'status' => false,
                'data' => null,
            ];
        }
    }

    // default = old image
    protected function image_upload($name, $dir, $default = null)
    {
        $result = $default;
        if (isset($_FILES[$name]) ? $_FILES[$name]['name'] != '' : false) {
            $image = $this->upload_foto($name, $dir);
            if ($image['status']) {
                $result = $image['data'];
                // hapus old foto

                if ($default != null) {
                    $old_file = $dir . "/../../../$default";
                    if (file_exists($old_file)) {
                        try {
                            unlink($old_file);
                        } catch (\Throwable $th) {
                        }
                    }
                }
            }
        }

        return $result;
    }

    // buat fungsi remove foto

    public function page_not_found()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->output_json(['message' => 'Route not found'], 404);
        } else {
            $this->template = null;
            $this->title = 'Page Not Found';
            $this->render('404');
        }
        die;
    }
}
