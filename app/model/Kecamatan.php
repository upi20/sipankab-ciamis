<?php
class Kecamatan extends Model
{
    public function create($nama)
    {
        $nama = value_sql_null($nama);

        query_build("INSERT INTO `kecamatan` (`nama`) VALUES ($nama)");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function update($id, $nama)
    {
        $nama = value_sql_null($nama);
        query_build("UPDATE `kecamatan` SET nama = $nama WHERE id = '$id'");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function find($id)
    {
        $staf = query_one("SELECT * from `kecamatan` where id = '$id' limit 1");
        return $staf;
    }

    public function delete($id)
    {
        $result = query_build("DELETE FROM kecamatan where id='$id'");
        return $result;
    }

    public function datatable($draw = null, $length = null, $start = null, $search = null, $order = null, $filter = null, $count = false)
    {
        $query_search = '';
        $search = mysqli_real_escape_string(conn(), $search);
        if (!in_array($search, ['', null])) {
            $query_search = <<<SQL
                (kecamatan.nama like '%$search%')
            SQL;
        }

        $filter_query = '';
        // filter aktif
        if (isset($filter['aktif']) ? ($filter['aktif'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $aktif = $filter['aktif'];
            $filter_query .= " kecamatan.aktif = $aktif";
        }

        // klinik where and
        $query_where = ($query_search != '' || $filter_query != '') ? ' where ' : '';
        // order custom
        $order_by = '';
        if ($order['order'] != null) {
            $columns = $order['columns'];
            $dir = $order['order'][0]['dir'];
            $order = $order['order'][0]['column'];
            $columns = $columns[$order];

            $order_colum = $columns['data'];
            if ($order_colum == 'nama') $order_colum = 'kecamatan.nama';
            $order_by = "order by $order_colum $dir";
        }
        // order default
        else {
            $order_by = "order by kecamatan.nama asc";
        }
        // person, user, klinik staf

        $query_from_where = <<<SQL
            from kecamatan $query_where  $query_search $filter_query $order_by
        SQL;

        if ($count) {
            $result = $this->query_one("SELECT count(*) as aggregate $query_from_where");
            return isset($result['aggregate']) ? $result['aggregate'] : 0;
        } else {
            $sql = "SELECT * $query_from_where limit $length offset $start";
            return $this->query_array($sql);
        }
    }
}
