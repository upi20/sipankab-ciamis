<?php
if (!function_exists('cekLogin')) {
    /**
     * Cek login, jika login akan di teruskan,
     * tapi jika belum maka akan di arahkan ke logout untuk selanjutnya login
     * @param $with_return
     * @return bool
     */
    function cekLogin($with_return = false)
    {
        $route_klinik = route('login');

        // session auth ada
        if (!isset($_SESSION['auth']) && !$with_return) {
            header("Location: $route_klinik");
        }

        if (!isset($_SESSION['auth']) && $with_return) return false;

        // role sebagai dokter
        $role = isset($_SESSION['auth']['role']) ? $_SESSION['auth']['role'] : null;
        $was_role = 'staf';
        if ($role != $was_role && !$with_return) {
            header("Location: $route_klinik");
        }

        if ($role != $was_role && $with_return) return false;

        $email = isset($_SESSION['auth']['email']) ? $_SESSION['auth']['email'] : 0;

        $sql = "SELECT count(*) as aggregate from admin where email = '$email'";

        $cek = query_one($sql);
        // jika user tidak ditemukan dan tidak untuk di return
        if ($cek['aggregate'] < 1 && !$with_return) {
            unset($_SESSION);
            header("Location: $route_klinik");
        }

        // jika user tidak ditemukan dan nilai return dibutuhkan
        if ($cek['aggregate'] < 1 && $with_return) return false;
        return true;
    }
}
