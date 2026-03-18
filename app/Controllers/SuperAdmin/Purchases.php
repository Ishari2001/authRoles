<?php

namespace App\Controllers\SuperAdmin;
use App\Controllers\BaseController;
use App\Models\PurchaseModel;

class Purchases extends BaseController
{
    public function index()
    {
        $model = new PurchaseModel();

        $data['purchases'] = $model
            ->orderBy('id','DESC')
            ->findAll();

        return view('admin/purchases', $data);
    }
}