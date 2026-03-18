<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\CommissionModel;

class Commissions extends BaseController
{
    public function index()
    {
        $model = new CommissionModel();

        $data['commissions'] = $model
            ->select('
                commissions.*, 
                u1.name as sponsor_name,
                u2.name as from_name
            ')
            ->join('users u1', 'u1.id = commissions.sponsor_id', 'left')
            ->join('users u2', 'u2.id = commissions.from_user_id', 'left')
            ->findAll();

        return view('superadmin/commission', $data);
    }
}