<?php
class Tahapan extends Model
{
    public function create($nama, $urutan)
    {
        $nama = value_sql_null($nama);
        $urutan = value_sql_null($urutan);

        query_build("INSERT INTO `tahapan` (`nama`, `urutan`) VALUES ($nama, $urutan)");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function update($id, $nama, $urutan)
    {
        $nama = value_sql_null($nama);
        $urutan = value_sql_null($urutan);
        query_build("UPDATE `tahapan` SET nama = $nama, urutan = $urutan WHERE id = '$id'");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function find($id)
    {
        $staf = query_one("SELECT * from `tahapan` where id = '$id' limit 1");
        return $staf;
    }

    public function delete($id)
    {
        $result = query_build("DELETE FROM tahapan where id='$id'");
        return $result;
    }

    public function datatable($draw = null, $length = null, $start = null, $search = null, $order = null, $filter = null, $count = false)
    {
        $query_search = '';
        $search = mysqli_real_escape_string(conn(), $search);
        if (!in_array($search, ['', null])) {
            $query_search = <<<SQL
                (tahapan.nama like '%$search%' or tahapan.urutan like '%$search%')
            SQL;
        }

        $filter_query = '';
        // filter aktif
        if (isset($filter['aktif']) ? ($filter['aktif'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $aktif = $filter['aktif'];
            $filter_query .= " tahapan.aktif = $aktif";
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
            if ($order_colum == 'nama') $order_colum = 'tahapan.nama';
            $order_by = "order by $order_colum $dir";
        }
        // order default
        else {
            $order_by = "order by tahapan.nama asc";
        }
        // person, user, klinik staf

        $query_from_where = <<<SQL
            from tahapan $query_where  $query_search $filter_query $order_by
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
