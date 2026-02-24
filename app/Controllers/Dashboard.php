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

        $userId   = session()->get('id');
        $ticketId = $this->request->getPost('ticket_id');

        $user   = $userModel->find($userId);
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
        // MLM LOGIC
        // -----------------------------
        $commissionAmount = 0;
        $userShare        = $amount;

        if (!empty($user['sponsor_id'])) {
            $sponsor = $userModel->find($user['sponsor_id']);
            if ($sponsor) {
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

        // Reduce ticket stock
        $ticketModel->update($ticketId, [
            'qty' => $ticket['qty'] - 1
        ]);

        // Save purchase history
        $db = \Config\Database::connect();
        $db->table('purchases')->insert([
            'user_id'   => $userId,
            'ticket_id' => $ticketId,
            'price'     => $amount,
            'created_at'=> date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with(
            'success',
            "Ticket Purchased Successfully! You received Rs. $userShare" .
            ($commissionAmount ? " | Sponsor earned Rs. $commissionAmount" : "")
        );
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