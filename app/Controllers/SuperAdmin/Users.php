<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TicketModel;
use App\Models\PurchaseModel;
use App\Models\CommissionModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $ticketModel = new TicketModel();
        $purchaseModel = new PurchaseModel();
        $commissionModel = new CommissionModel();

        // ✅ Users list
        $data['users'] = $userModel->findAll();

        // ✅ Stats (for your top cards)
        $data['totalUsers'] = $userModel->countAll();
        $data['totalTickets'] = $ticketModel->countAll();

        $data['totalSales'] = $purchaseModel
            ->selectSum('price')
            ->first()['price'] ?? 0;

        $data['totalCommission'] = $commissionModel
            ->selectSum('amount')
            ->first()['amount'] ?? 0;

        return view('superadmin/users', $data);
    }

    // ✅ Delete user
    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('/superadmin/users')->with('success','User deleted');
    }
}