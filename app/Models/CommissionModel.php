<?php

namespace App\Models;
use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commissions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sponsor_id',     // who earned
        'from_user_id',   // who purchased
        'amount'          // commission value
    ];

    protected $useTimestamps = false; // optional (if table has created_at)
}