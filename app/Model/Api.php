<?php

namespace App\Model;

use App\Core\Model;
use App\Core\Response;

class Api extends Model
{
    public function install()
    {
        if (!file_exists(SQL_FILE))
            return "Cannot find SQL file";

        try {
            $sql = file_get_contents(SQL_FILE);
            $this->db->exec($sql);
        } catch(\PDOException $e) {
            return "Error: " . $e->getMessage();
        }

        return "Success";
    }
}