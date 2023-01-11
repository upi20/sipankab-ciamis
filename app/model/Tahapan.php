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

    // nilai
    public function nilai_create($tahapan_id, $urutan, $nilai, $nilai_nama, $nilai_dari, $nilai_sampai)
    {
        $tahapan_id = value_sql_null($tahapan_id);
        $urutan = value_sql_null($urutan);
        $nilai = value_sql_null($nilai);
        $nilai_nama = value_sql_null($nilai_nama);
        $nilai_dari = value_sql_null($nilai_dari);
        $nilai_sampai = value_sql_null($nilai_sampai);

        query_build("INSERT INTO `tahapan_nilai` 
        ( `tahapan_id`, `urutan`, `nilai`, `nilai_nama`, `nilai_dari`, `nilai_sampai` )
         VALUES 
        ( $tahapan_id, $urutan, $nilai, $nilai_nama, $nilai_dari, $nilai_sampai )");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function nilai_update($id, $tahapan_id, $urutan, $nilai, $nilai_nama, $nilai_dari, $nilai_sampai)
    {
        $id = value_sql_null($id);
        $tahapan_id = value_sql_null($tahapan_id);
        $urutan = value_sql_null($urutan);
        $nilai = value_sql_null($nilai);
        $nilai_nama = value_sql_null($nilai_nama);
        $nilai_dari = value_sql_null($nilai_dari);
        $nilai_sampai = value_sql_null($nilai_sampai);

        query_build("UPDATE `tahapan_nilai` SET 
        tahapan_id = $tahapan_id,
        urutan = $urutan,
        nilai = $nilai,
        nilai_nama = $nilai_nama,
        nilai_dari = $nilai_dari,
        nilai_sampai = $nilai_sampai
        WHERE id = $id");
        return [
            'code' => 200,
            'error' => false,
            'message' => 'Data Berhasil Disimpan'
        ];
    }

    public function nilai_find($id)
    {
        $staf = query_one("SELECT * from `tahapan_nilai` where id = '$id' limit 1");
        return $staf;
    }

    public function nilai_delete($id)
    {
        $result = query_build("DELETE FROM tahapan_nilai where id='$id'");
        return $result;
    }

    public function nilai_datatable($draw = null, $length = null, $start = null, $search = null, $order = null, $filter = null, $count = false)
    {
        $query_search = '';
        $search = mysqli_real_escape_string(conn(), $search);
        if (!in_array($search, ['', null])) {
            $query_search = <<<SQL
                ( tahapan_nilai.tahapan_id like '%$search%' or 
                    tahapan_nilai.urutan like '%$search%' or 
                    tahapan_nilai.nilai like '%$search%' or 
                    tahapan_nilai.nilai_nama like '%$search%' or 
                    tahapan_nilai.nilai_dari like '%$search%' or 
                    tahapan_nilai.nilai_sampai like '%$search%' )
            SQL;
        }

        $filter_query = '';
        // filter aktif
        if (isset($filter['tahapan_id']) ? ($filter['tahapan_id'] != '') : false) {
            $filter_query .= ($query_search != '' || $filter_query != '') ? ' and ' : '';
            $tahapan_id = $filter['tahapan_id'];
            $filter_query .= " tahapan_nilai.tahapan_id = $tahapan_id";
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
            if ($order_colum == 'nama') $order_colum = 'tahapan_nilai.nama';
            $order_by = "order by $order_colum $dir";
        }
        // order default
        else {
            $order_by = "order by tahapan_nilai.nama asc";
        }
        // person, user, klinik staf

        $query_from_where = <<<SQL
            from tahapan_nilai $query_where  $query_search $filter_query $order_by
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
