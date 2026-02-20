<?php

namespace App\Models;
use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';

    protected $allowedFields = [
        'title',
        'description',
        'price',
        'event_date',
        'qty',
        'purchase_start',
        'purchase_end',
        'image'
    ];
}