<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
{
    if (!session()->get('logged')) {
        return redirect()->to('/login');
    }

    $userId = session()->get('id');

    // ✅ Build referral link from logged user
    $refLink = base_url('register?ref=' . $userId);

    $data = [
        'name'    => session()->get('name'),
        'role'    => session()->get('role'),
        'refLink' => $refLink   // ✅ MUST pass to view
    ];

    return view('home', $data);
}
}
