<?php

/**
 * Core Model
 */
class Model
{
    protected $klinik;
    public function __construct()
    {
        $this->klinik = klinik_kode();
    }

    public function query_array($query)
    {
        $result = $this->query($query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function query($query)
    {
        return mysqli_query(conn(), $query);
    }

    public function query_one($query)
    {
        $result = $this->query($query);
        return mysqli_fetch_assoc($result);
    }
}
