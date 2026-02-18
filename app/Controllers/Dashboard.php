<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CommissionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('id'));

        $data = [
            'name'         => $user['name'],
            'role'         => $user['role'],
            'wallet'       => $user['wallet'],
            'sponsor_name' => $user['sponsor_id'] ? $userModel->find($user['sponsor_id'])['name'] : 'None'
        ];

        return view('dashboard/index', $data);
    }

public function purchaseTicket()
{
    if (!session()->get('logged')) {
        return redirect()->to('/login');
    }

    $userModel = new UserModel();
    $commissionModel = new CommissionModel();

    $userId = session()->get('id');
    $user   = $userModel->find($userId);

    $amount = (float)$this->request->getPost('amount');

    if (!$amount || $amount <= 0) {
        return redirect()->back()->with('error', 'Enter a valid ticket amount.');
    }

    /*
    ----------------------------------------------------
    CHECK: Did this user register under a sponsor?
    ----------------------------------------------------
    */

    if (empty($user['sponsor_id'])) {

        // ❌ NO SPONSOR → User keeps 100%
        $userModel->update($userId, [
            'wallet' => $user['wallet'] + $amount
        ]);

        return redirect()->back()->with(
            'success',
            "Ticket Purchased! No sponsor found — Full $$amount added to your wallet."
        );
    }

    /*
    ----------------------------------------------------
    USER HAS SPONSOR → Apply MLM Distribution
    ----------------------------------------------------
    */

    $sponsor = $userModel->find($user['sponsor_id']);

    // Safety check (in case sponsor was deleted)
    if (!$sponsor) {

        // Treat like no sponsor
        $userModel->update($userId, [
            'wallet' => $user['wallet'] + $amount
        ]);

        return redirect()->back()->with(
            'success',
            "Sponsor not found — Full $$amount added to your wallet."
        );
    }

    // Commission calculation
    $commissionAmount = $amount * 0.10; // 10% to sponsor
    $userShare        = $amount - $commissionAmount; // 90% to user

    // Add to student
    $userModel->update($userId, [
        'wallet' => $user['wallet'] + $userShare
    ]);

    // Add to sponsor
    $userModel->update($user['sponsor_id'], [
        'wallet' => $sponsor['wallet'] + $commissionAmount
    ]);

    // Log commission
    $commissionModel->insert([
        'sponsor_id'   => $user['sponsor_id'],
        'from_user_id' => $userId,
        'amount'       => $commissionAmount
    ]);

    return redirect()->back()->with(
        'success',
        "Ticket Purchased! You received $$userShare and your sponsor earned $$commissionAmount."
    );
}



}
