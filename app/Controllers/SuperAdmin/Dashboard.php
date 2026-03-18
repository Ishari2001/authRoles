<?php

namespace App\Controllers\SuperAdmin;
use App\Controllers\BaseController;

use App\Models\UserModel;
use App\Models\TicketModel;
use App\Models\PurchaseModel;
use App\Models\CommissionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $ticketModel = new TicketModel();
        $purchaseModel = new PurchaseModel();
        $commissionModel = new CommissionModel();

        $data['totalUsers'] = $userModel->countAll();
        $data['totalTickets'] = $ticketModel->countAll();

        $data['totalSales'] = $purchaseModel
            ->selectSum('price')
            ->first()['price'] ?? 0;

        $data['totalCommission'] = $commissionModel
            ->selectSum('amount')
            ->first()['amount'] ?? 0;

        // 👇 IMPORTANT: commissions for your table
        $data['commissions'] = $commissionModel
            ->orderBy('id','DESC')
            ->findAll();

        // 👇 IMPORTANT: tickets for your table
        $data['tickets'] = $ticketModel->findAll();

        return view('superadmin/layout', $data);
    }
}