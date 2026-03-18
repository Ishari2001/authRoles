<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\TicketModel;

class Tickets extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    // ✅ Show all tickets
    public function index()
    {
        $data['tickets'] = $this->ticketModel->findAll();
        return view('superadmin/tickets', $data);
    }

    // ✅ Save new ticket
    public function save()
    {
        $file = $this->request->getFile('image');
        $imageName = null;

        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/tickets/', $imageName);
        }

        $this->ticketModel->save([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'qty' => $this->request->getPost('qty'),
            'event_date' => $this->request->getPost('event_date'),
            'purchase_start' => $this->request->getPost('purchase_start'),
            'purchase_end' => $this->request->getPost('purchase_end'),
            'image' => $imageName
        ]);

        return redirect()->to('/superadmin/tickets')->with('success', 'Ticket Added');
    }

    // ✅ Update ticket
    public function update()
    {
        $id = $this->request->getPost('id');

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'qty' => $this->request->getPost('qty'),
            'event_date' => $this->request->getPost('event_date'),
            'purchase_start' => $this->request->getPost('purchase_start'),
            'purchase_end' => $this->request->getPost('purchase_end'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/tickets/', $imageName);
            $data['image'] = $imageName;
        }

        $this->ticketModel->update($id, $data);

        return redirect()->to('/superadmin/tickets')->with('success', 'Ticket Updated');
    }

    // ✅ Delete ticket
    public function delete($id)
    {
        $this->ticketModel->delete($id);
        return redirect()->to('/superadmin/tickets')->with('success', 'Ticket Deleted');
    }

   
}