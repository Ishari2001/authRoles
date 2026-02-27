<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TicketModel;
use App\Models\CommissionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged')) {
            return redirect()->to('/login');
        }

        $userModel   = new UserModel();
        $ticketModel = new TicketModel();

        $user = $userModel->find(session()->get('id'));

        $data = [
            'name'    => $user['name'],
            'role'    => $user['role'],
            'wallet'  => $user['wallet'],
            'tickets' => $ticketModel->orderBy('id','DESC')->findAll()
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
    $db              = \Config\Database::connect();

    $userId   = session()->get('id');
    $ticketId = (int)$this->request->getPost('ticket_id');

    // -----------------------------
    // VALIDATION
    // -----------------------------
    if (!$ticketId) {
        return redirect()->back()->with('error', 'Invalid Ticket.');
    }

    $user = $userModel->find($userId);

    // User deleted while logged in
    if (!$user) {
        session()->destroy();
        return redirect()->to('/login')->with('error', 'User no longer exists.');
    }

    $ticket = $ticketModel->find($ticketId);

    if (!$ticket) {
        return redirect()->back()->with('error', 'Ticket not found.');
    }

    $now = date('Y-m-d H:i:s');

    if ($now < $ticket['purchase_start'] || $now > $ticket['purchase_end']) {
        return redirect()->back()->with('error', 'Ticket sales are closed.');
    }

    if ($ticket['qty'] <= 0) {
        return redirect()->back()->with('error', 'Ticket Sold Out.');
    }

    $amount = (float)$ticket['price'];

    // -----------------------------
    // START TRANSACTION (IMPORTANT)
    // -----------------------------
    $db->transStart();

    // Lock ticket row (avoid double purchase)
    $ticket = $db->table('tickets')
        ->where('id', $ticketId)
        ->get()
        ->getRowArray();

    if ($ticket['qty'] <= 0) {
        $db->transRollback();
        return redirect()->back()->with('error', 'Ticket Sold Out.');
    }

    // -----------------------------
    // MLM COMMISSION (LEVEL 1 + 2)
    // -----------------------------
    $level1Commission = 0;
    $level2Commission = 0;
    $userShare        = $amount;

    // ===== LEVEL 1 =====
    if (!empty($user['sponsor_id'])) {

        $level1 = $userModel->find($user['sponsor_id']);

        if ($level1) {

            $level1Commission = $amount * 0.10;
            $userShare -= $level1Commission;

            $userModel->update($level1['id'], [
                'wallet' => $level1['wallet'] + $level1Commission
            ]);

            $commissionModel->insert([
                'sponsor_id'   => $level1['id'],
                'from_user_id' => $userId,
                'ticket_id'    => $ticketId,
                'amount'       => $level1Commission,
                'level'        => 1
            ]);

            // ===== LEVEL 2 =====
            if (!empty($level1['sponsor_id'])) {

                $level2 = $userModel->find($level1['sponsor_id']);

                if ($level2) {

                    $level2Commission = $amount * 0.05;
                    $userShare -= $level2Commission;

                    $userModel->update($level2['id'], [
                        'wallet' => $level2['wallet'] + $level2Commission
                    ]);

                    $commissionModel->insert([
                        'sponsor_id'   => $level2['id'],
                        'from_user_id' => $userId,
                        'ticket_id'    => $ticketId,
                        'amount'       => $level2Commission,
                        'level'        => 2
                    ]);
                }
            }
        }
    }

    
    // -----------------------------
    // ADD BUYER SHARE
    // -----------------------------
    $userModel->update($userId, [
        'wallet' => $user['wallet'] + $userShare
    ]);

    // -----------------------------
    // REDUCE STOCK SAFELY
    // -----------------------------
    $db->table('tickets')
        ->where('id', $ticketId)
        ->set('qty', 'qty - 1', false)
        ->update();

    // -----------------------------
    // SAVE PURCHASE
    // -----------------------------
    $db->table('purchases')->insert([
        'user_id'    => $userId,
        'ticket_id'  => $ticketId,
        'price'      => $amount,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Transaction failed.');
    }

    // -----------------------------
    // SUCCESS MESSAGE
    // -----------------------------
    $msg = "Ticket Purchased! You received Rs. $userShare";

    if ($level1Commission) {
        $msg .= " | Level1 earned Rs. $level1Commission";
    }

    if ($level2Commission) {
        $msg .= " | Level2 earned Rs. $level2Commission";
    }

    return redirect()->back()->with('success', $msg);
}



    public function home()
{
    if (!session()->get('logged')) {
        return redirect()->to('/login');
    }

    $userId = session()->get('id');

    $data['refLink'] = base_url('register?ref=' . $userId);

    

    return view('home', $data);
}

}