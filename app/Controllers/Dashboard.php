<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CommissionModel;
use App\Models\TicketModel;

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

    $userModel       = new UserModel();
    $ticketModel     = new TicketModel();
    $commissionModel = new CommissionModel();

    $userId   = session()->get('id');
    $ticketId = $this->request->getPost('ticket_id');

    $user   = $userModel->find($userId);
    $ticket = $ticketModel->find($ticketId);

    // -----------------------------
    // VALIDATE TICKET
    // -----------------------------
    if (!$ticket) {
        return redirect()->back()->with('error', 'Ticket not found.');
    }

    $now = date('Y-m-d H:i:s');

    // Check selling window
    if ($now < $ticket['purchase_start'] || $now > $ticket['purchase_end']) {
        return redirect()->back()->with('error', 'Ticket sales are closed.');
    }

    // Check quantity
    if ($ticket['qty'] <= 0) {
        return redirect()->back()->with('error', 'Ticket Sold Out.');
    }

    // Ticket price (NOT manual input anymore)
    $amount = (float)$ticket['price'];

    /*
    -----------------------------------
    MLM LOGIC
    -----------------------------------
    */

    $commissionAmount = 0;
    $userShare        = $amount;

    if (!empty($user['sponsor_id'])) {

        $sponsor = $userModel->find($user['sponsor_id']);

        if ($sponsor) {
            // 10% sponsor commission
            $commissionAmount = $amount * 0.10;
            $userShare        = $amount - $commissionAmount;

            // Add commission to sponsor wallet
            $userModel->update($sponsor['id'], [
                'wallet' => $sponsor['wallet'] + $commissionAmount
            ]);

            // Log commission
            $commissionModel->insert([
                'sponsor_id'   => $sponsor['id'],
                'from_user_id' => $userId,
                'amount'       => $commissionAmount,
                'ticket_id'    => $ticketId
            ]);
        }
    }

    // Add remaining to buyer wallet
    $userModel->update($userId, [
        'wallet' => $user['wallet'] + $userShare
    ]);

    // -----------------------------
    // REDUCE STOCK
    // -----------------------------
    $ticketModel->update($ticketId, [
        'qty' => $ticket['qty'] - 1
    ]);

    // -----------------------------
    // SAVE PURCHASE HISTORY
    // -----------------------------
    $db = \Config\Database::connect();
    $db->table('purchases')->insert([
        'user_id'   => $userId,
        'ticket_id' => $ticketId,
        'price'     => $amount,
        'created_at'=> date('Y-m-d H:i:s')
    ]);

    return redirect()->back()->with(
        'success',
        "Ticket Purchased Successfully! You received $$userShare" .
        ($commissionAmount ? " | Sponsor earned $$commissionAmount" : "")
    );
}




}
