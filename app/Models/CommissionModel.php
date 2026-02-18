<?php

namespace App\Models;
use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commissions';
    protected $allowedFields = ['sponsor_id','from_user_id','amount'];
}
