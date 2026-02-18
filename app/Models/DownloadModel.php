<?php

namespace App\Models;

use CodeIgniter\Model;

class DownloadModel extends Model
{
    protected $table = 'users ';
    protected $primaryKey = 'id';

    public function getUserData()
    {
        return $this->findAll();
    }
}
