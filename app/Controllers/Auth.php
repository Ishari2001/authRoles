<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    public function login()
    {
        
        if ($this->session->get('logged')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

 public function register()
{
    $ref = $this->request->getGet('ref');

    if ($ref && is_numeric($ref)) {

        // Check if ref user exists
        $userModel = new UserModel();
        $refUser   = $userModel->find($ref);

        if ($refUser) {
            session()->set('referral_id', $ref);
        }
    }

    return view('auth/register');
}

    public function doLogin()
    {
        $model    = new UserModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {

            // ✅ IMPORTANT: regenerate session (security)
            $this->session->regenerate();

            // ✅ Your original session data (unchanged)
            $this->session->set([
                'id'     => $user['id'],
                'name'   => $user['name'],
                'role'   => $user['role'],
                'logged' => true
            ]);

            return redirect()->to('/home');
        }

        return redirect()->back()->with('error', 'Invalid Login');
    }

    public function logout()
    {
        // ✅ Destroy safely
        $this->session->remove(['id','name','role','logged']);
        $this->session->destroy();

        return redirect()->to('/login');
    }

    // ✅ REGISTER USER (NO LOGIC CHANGED)
    public function registerSave()
{
    $userModel = new UserModel();

    $name     = $this->request->getPost('name');
    $email    = $this->request->getPost('email');
    $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

    if ($userModel->where('email', $email)->first()) {
        return redirect()->back()->with('error', 'Email already registered');
    }

    // ✅ Get sponsor from session (URL ref)
    $sponsor_id = session()->get('referral_id');

    if ($sponsor_id && !$userModel->find($sponsor_id)) {
        $sponsor_id = null;
    }

    $userModel->insert([
        'name'       => $name,
        'email'      => $email,
        'password'   => $password,
        'role'       => 4,
        'sponsor_id' => $sponsor_id,
        'wallet'     => 0
    ]);

    $newUserId = $userModel->getInsertID();

    // clear referral so it won't reuse accidentally
    session()->remove('referral_id');

    return redirect()->to('/login')
        ->with('success', 'Registration Successful!');
}

    // ✅ AJAX Sponsor Check (UNCHANGED)
    public function getSponsorName()
    {
        $userModel = new UserModel();
        $id        = $this->request->getGet('id');

        if (!$id) {
            return $this->response->setJSON(['name' => null]);
        }

        $sponsor = $userModel->find($id);

        return $this->response->setJSON([
            'name' => $sponsor ? $sponsor['name'] : null
        ]);
    }
}
