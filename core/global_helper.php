<?php
if (!function_exists('is_production')) {
    /**
     * Cek apakah prameter url diganti menjadi hexa
     * @return bool
     */
    function is_production()
    {
        global $production;
        // default production true
        return isset($production) ? $production : true;
    }
}

if (!function_exists('e')) {
    /**
     * @param string $string
     * Enkripsi teks menjadi heksa
     * @return string
     */
    function e($string)
    {
        if (!is_production()) return $string;
        // string reverse
        $string = strrev($string);
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $ord = ord($string[$i]) + 1;
            $hexCode = dechex($ord);
            $hex .= substr('0' . $hexCode, -2);
        }
        return strToUpper($hex);
    }
}

if (!function_exists('d')) {
    /**
     * @param string $hex
     * Enkripsi heksa menjadi teks
     * @return string
     */
    function d($hex)
    {
        if (!is_production()) return $hex;
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]) - 1);
        }

        // string reverse
        return strrev($string);
    }
}

if (!function_exists('base_url')) {
    /**
     * @param string|null $url
     * Url yang relevan untuk module ini
     * @return string
     */
    function base_url($url = null)
    {
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://" . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        return $base_url . ($url ? $url : '');
    }
}

if (!function_exists('asset')) {
    /**
     * @param string|null $url
     * Url yang relevan untuk module ini
     * @return string
     */
    function asset($url = null)
    {
        global $dir;
        global $deep_dir;
        return base_url($deep_dir . $url);
    }
}

if (!function_exists('controller_dir')) {
    /**
     * @param $name
     * folder direktori controller
     * @return string
     */
    function controller_dir($name)
    {
        global $dir;
        return $dir . "/controller/$name";
    }
}

if (!function_exists('route')) {
    /**
     * @param $name
     * @param array|null $param
     * 
     * @return string
     */
    function route($name, $params = [], $prefix = null)
    {
        $name = e($name);
        $r = e('r');
        $prefix = $prefix ?? base_url();
        $param_query = '';
        foreach ($params as $key => $param) {
            $param = e($param);
            $key = e($key);
            $param_query .= "&$key=$param";
        }
        return "$prefix?$r=$name{$param_query}";
    }
}

if (!function_exists('route_get')) {
    /**
     * @param $name
     * @param $file
     * @param $fun
     * rute menggunakan metod get
     * @return void
     */
    function route_get($name, $file, $fun)
    {
        if ((isset($_GET[e('r')]) && $_SERVER['REQUEST_METHOD'] === 'GET') ? ($_GET[e('r')] === e($name)) : false) {
            require controller_dir("$file.php");
            $file = new $file();
            $file->$fun();
            die;
        }
        // home
        else if (($_SERVER['REQUEST_METHOD'] === 'GET') && ($name === '')) {
            require controller_dir("$file.php");
            $file = new $file();
            $file->$fun();
            die;
        }
    }
}

if (!function_exists('route_post')) {
    /**
     * @param $name
     * @param $file
     * @param $fun
     * rute menggunakan metod post
     * @return void
     */
    function route_post($name, $file, $fun)
    {
        if ((isset($_GET[e('r')]) && $_SERVER['REQUEST_METHOD'] === 'POST') ? ($_GET[e('r')] === e($name)) : false) {
            require controller_dir("$file.php");
            $file = new $file();
            $file->$fun();
            die;
        }
        // home
        else if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($name === '')) {
            require controller_dir("$file.php");
            $file = new $file();
            $file->$fun();
            die;
        }
    }
}

if (!function_exists('route_has')) {
    /**
     * @param $name
     * cek rute 
     * @return bool
     */
    function route_has($name)
    {
        return (isset($_GET[e('r')])) ? ($_GET[e('r')] === e($name)) : ($name === '');
    }
}

if (!function_exists('route_active_class')) {
    /**
     * @param $name
     * @param $class
     * cek rute kemudian buat output teks sesuai dengan argumen class
     * @return string
     */
    function route_active_class($name, $class)
    {
        return route_has($name) ? $class : '';
    }
}

if (!function_exists('app_path')) {
    /**
     * @param string|null $name
     * Path aplikasi
     * @return string
     */
    function app_path($name = null)
    {
        global $dir;
        return $dir . ($name ? "/$name" : "");
    }
}

if (!function_exists('get')) {
    /**
     * @param string $name
     * @param bool $encrypt
     * Ambil data method get
     * @return mixed
     */
    function get($name, $encrypt = true)
    {
        $name = $encrypt ? e($name) : $name;
        if (isset($_GET[$name])) {
            return $_GET[$name] == '' ? null : ($encrypt ? d($_GET[$name]) : $_GET[$name]);
        } else {
            return null;
        }
    }
}

if (!function_exists('post')) {
    /**
     * @param $name
     * ambil data method post
     * @return mixed
     */
    function post($name)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name] == '' ? null : $_POST[$name];
        } else {
            return null;
        }
    }
}

if (!function_exists('conn')) {
    /**
     * Ambil data koneksi mysqli
     * @return mixed
     */
    function conn()
    {
        global $conn;
        mysqli_query($conn, "SET lc_time_names = 'id_ID'");
        return $conn;
    }
}

// hash password
if (!function_exists('bcrypt_hash')) {
    function bcrypt_hash($password, $round = 10)
    {
        $config = ['cost' => $round];
        return password_hash($password, PASSWORD_BCRYPT, $config);
    }
}

// match password
if (!function_exists('hash_check')) {
    function hash_check($password, $hashed_password)
    {
        return password_verify($password, $hashed_password);
    }
}

if (!function_exists('mrq')) {
    /**
     * @param string|null $text
     * mysqli_real_escape_string ubah teks escape yang berpotensi untuk merusak atau menjebol database
     * @return string
     */
    function mrq($text)
    {
        return is_null($text) ? null : mysqli_real_escape_string(conn(), $text);
    }
}

if (!function_exists('query_build')) {
    /**
     * @param $query
     * query ke database dengan string biasa
     * @return mixed
     */
    function query_build($query)
    {
        return mysqli_query(conn(), $query);
    }
}

if (!function_exists('query_array')) {
    /**
     * @param $query
     * query ke database dengan hasil list array
     * @return mixed
     */
    function query_array($query)
    {
        $result = query_build($query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

if (!function_exists('query_one')) {
    /**
     * @param $query
     * query ke database dengan hasil satu array pertama
     * @return mixed
     */
    function query_one($query)
    {
        $result = query_build($query);
        return mysqli_fetch_assoc($result);
    }
}

if (!function_exists('qrcode')) {
    /**
     * @param string|null $url
     * Generate qrcode dari teks
     * @return string
     */
    function qrcode($key = null)
    {
        global $deep_dir;
        $key = is_null($key) ? '' : urlencode($key);
        return base_url("qrcode/$deep_dir?key=$key");
    }
}

if (!function_exists('klinik_kode')) {
    /**
     * Get klinik user
     * @return string
     */
    function klinik_kode()
    {
        try {
            return isset($_SESSION['auth']['klinik_kode']) ? $_SESSION['auth']['klinik_kode'] : null;
        } catch (\Throwable $th) {
            return null;
        }
    }
}

if (!function_exists('get_setting')) {
    /**
     * Get klinik setting
     * @return string
     */
    function get_setting($klinik_kode = null)
    {
        $id = is_null($klinik_kode) ? klinik_kode() : $klinik_kode;
        return query_one("select * from t_klinik where klinik_kode = '$id'");
    }
}

if (!function_exists('value_sql_null')) {
    /**
     * @return string
     */
    function value_sql_null($value)
    {
        return is_null($value) ? "null" : ("'" . mrq($value) . "'");
    }
}

if (!function_exists('audio_list')) {
    /**
     * Get klinik setting
     * @return mixed
     */
    function audio_list()
    {
        global $deep_dir;

        $output = array();
        $directory = "assets/audio/";
        $directory_scann =  $deep_dir . $directory;
        $scanned_directory = array_diff(scandir($directory_scann), array('..', '.'));
        foreach ($scanned_directory as $r) {
            $ext = pathinfo($r, PATHINFO_EXTENSION);
            if (in_array($ext, array("MP3", "mp3", "wav"))) {
                $explode = explode(".", $r);
                $ID = $explode[0];
                $output[] = array(
                    'path' => asset($directory . $r),
                    'file' => $r,
                    'ID' => $ID,
                );
            }
        }
        return $output;
    }
}

if (!function_exists('base64_upload_file')) {
    function base64_upload_file($upload_dir, $name, $extension, $base64string)
    {
        if ($base64string == '' || $base64string == null) {
            return [
                'result' => false,
                'path' => null,
            ];
        }

        global $dir;
        global $deep_dir;

        // cek ketika menggunakan init.php maka folder nya akan berubah
        $deep_dir_plus = file_exists("$dir/init.php") ? '../' : '';

        $file_path = "assets/upload/$upload_dir/$name.$extension";
        $full_path = "$dir/" . $deep_dir . $deep_dir_plus . $file_path;

        $result = file_put_contents($full_path, base64_decode($base64string));

        return [
            'result' => $result,
            'path' => $file_path,
        ];
    }
}

if (!function_exists('slugify')) {
    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if (!function_exists('delete_file')) {
    function delete_file($file)
    {
        if (!$file) {
            return false;
        }
        global $dir;
        global $deep_dir;
        $full_path = "$dir/" . $deep_dir . $file;
        if (file_exists($full_path)) {
            try {
                return unlink($full_path);
            } catch (\Exception $th) {
                return $th;
            }
        } else {
            return false;
        }
    }
}
