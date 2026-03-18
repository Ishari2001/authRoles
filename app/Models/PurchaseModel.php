<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'ticket_id',
        'price',
        'created_at'
    ];
}