<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TicketModel;

use App\Models\CommissionModel;

class Admin extends BaseController
{
    // Show login page
    public function login()
    {
        return view('admin/login');
    }

    // Process login
    public function doLogin()
    {
        $model    = new UserModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $admin = $model
            ->where('email', $email)
            ->where('role', 1) // 1 = ADMIN ONLY
            ->first();

        if ($admin && password_verify($password, $admin['password'])) {

            session()->set([
                'admin_id'   => $admin['id'],
                'admin_name' => $admin['name'],
                'admin_role' => $admin['role'],
                'isAdmin'    => true
            ]);

            return redirect()->to('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid Admin Login');
    }

    // Admin Dashboard
public function dashboard()
{
    if (!session()->get('isAdmin')) {
        return redirect()->to('/admin/login');
    }

    $userModel       = new UserModel();
    $commissionModel = new CommissionModel();
    $ticketModel     = new TicketModel();

    $data['totalUsers']      = $userModel->countAll();
    $data['totalWallet']     = $userModel->selectSum('wallet')->first()['wallet'] ?? 0;
    $data['totalCommission'] = $commissionModel->selectSum('amount')->first()['amount'] ?? 0;

    $view = $this->request->getGet('view') ?? 'summary';
    $data['view'] = $view;

    // === USERS ===
    if ($view == 'users') {
        $data['users'] = $userModel->findAll();
    }
    // === COMMISSIONS ===
    elseif ($view == 'commissions') {
        $data['commissions'] = $commissionModel
            ->select('commissions.*, s.name as sponsor_name, u.name as buyer_name')
            ->join('users s', 's.id = commissions.sponsor_id')
            ->join('users u', 'u.id = commissions.from_user_id')
            ->orderBy('commissions.id', 'DESC')
            ->findAll();
    }
    // === TICKETS ===
    elseif ($view == 'tickets') {

        // Handle POST actions for tickets (Add / Edit / Delete)
        if ($this->request->getMethod() === 'post') {

            $action = $this->request->getPost('action');
            $ticketId = $this->request->getPost('id');

            // DELETE
            if ($action === 'delete' && $ticketId) {
                $ticketModel->delete($ticketId);
                session()->setFlashdata('success', 'Ticket deleted successfully!');
                return redirect()->to('/admin/dashboard?view=tickets');
            }

            // EDIT
            if ($action === 'edit' && $ticketId) {
                $ticket = $ticketModel->find($ticketId);
                if ($ticket) {
                    // Handle form submission for update
                    $title = $this->request->getPost('title');
                    $description = $this->request->getPost('description');
                    $price = $this->request->getPost('price');
                    $qty = $this->request->getPost('qty');
                    $event_date = $this->request->getPost('event_date');
                    $purchase_start = $this->request->getPost('purchase_start');
                    $purchase_end = $this->request->getPost('purchase_end');

                    // IMAGE
                    $file = $this->request->getFile('image');
                    $imageName = $ticket['image'];
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $imageName = $file->getRandomName();
                        $file->move(ROOTPATH . 'public/uploads/tickets/', $imageName);
                    }

                    $ticketModel->update($ticketId, [
                        'title'          => $title,
                        'description'    => $description,
                        'price'          => $price,
                        'qty'            => $qty,
                        'event_date'     => $event_date,
                        'purchase_start' => $purchase_start,
                        'purchase_end'   => $purchase_end,
                        'image'          => $imageName
                    ]);

                    session()->setFlashdata('success', 'Ticket updated successfully!');
                    return redirect()->to('/admin/dashboard?view=tickets');
                }
            }

            // ADD
            if ($action === 'add') {
                $file = $this->request->getFile('image');
                $imageName = null;
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $imageName = $file->getRandomName();
                    $file->move(ROOTPATH . 'public/uploads/tickets/', $imageName);
                }

                $ticketModel->insert([
                    'title'          => $this->request->getPost('title'),
                    'description'    => $this->request->getPost('description'),
                    'price'          => $this->request->getPost('price'),
                    'qty'            => $this->request->getPost('qty'),
                    'event_date'     => $this->request->getPost('event_date'),
                    'purchase_start' => $this->request->getPost('purchase_start'),
                    'purchase_end'   => $this->request->getPost('purchase_end'),
                    'image'          => $imageName
                ]);

                session()->setFlashdata('success', 'Ticket added successfully!');
                return redirect()->to('/admin/dashboard?view=tickets');
            }
        }

        // Fetch all tickets for display
        $data['tickets'] = $ticketModel->orderBy('id', 'DESC')->findAll();
    }

    return view('admin/dashboard', $data);
}



public function addTicket()
{
    if (!session()->get('isAdmin')) {
        return redirect()->to('/admin/login');
    }

    return view('admin/add_ticket');
}
public function saveTicket()
{
    if (!session()->get('isAdmin')) {
        return redirect()->to('/admin/login');
    }

    $ticketModel = new TicketModel();

    // -------------------------
    // VALIDATION
    // -------------------------
    $rules = [
        'title'          => 'required',
        'price'          => 'required|numeric',
        'qty'            => 'required|integer',
        'event_date'     => 'required',
        'purchase_start' => 'required',
        'purchase_end'   => 'required'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->with('error','Please fill all fields correctly');
    }

    // -------------------------
    // IMAGE UPLOAD
    // -------------------------
    $file = $this->request->getFile('image');
    $imageName = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $imageName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/tickets/', $imageName);
    }

    // -------------------------
    // SAVE DATA
    // -------------------------
    $ticketModel->insert([
        'title'          => $this->request->getPost('title'),
        'description'    => $this->request->getPost('description'),
        'price'          => $this->request->getPost('price'),
        'qty'            => $this->request->getPost('qty'),
        'event_date'     => $this->request->getPost('event_date'),
        'purchase_start' => $this->request->getPost('purchase_start'),
        'purchase_end'   => $this->request->getPost('purchase_end'),
        'image'          => $imageName
    ]);

    return redirect()->to('/admin/tickets')->with('success','Ticket Added Successfully');
}


public function getTicket()
{
    $id = $this->request->getPost('id');
    $ticketModel = new TicketModel();

    return $this->response->setJSON($ticketModel->find($id));
}

public function updateTicketAjax()
{
    $ticketModel = new TicketModel();

    $id = $this->request->getPost('id');

    $data = [
        'title'          => $this->request->getPost('title'),
        'description'    => $this->request->getPost('description'),
        'price'          => $this->request->getPost('price'),
        'qty'            => $this->request->getPost('qty'),
        'event_date'     => $this->request->getPost('event_date'),
        'purchase_start' => $this->request->getPost('purchase_start'),
        'purchase_end'   => $this->request->getPost('purchase_end'),
    ];

    // Image optional
    $file = $this->request->getFile('image');
    if ($file && $file->isValid()) {
        $name = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/tickets/', $name);
        $data['image'] = $name;
    }

    $ticketModel->update($id, $data);

    return $this->response->setJSON(['status' => 'success']);
}

public function deleteTicketAjax()
{
    $id = $this->request->getPost('id');
    $ticketModel = new TicketModel();
    $ticketModel->delete($id);

    return $this->response->setJSON(['status' => 'deleted']);
}


}