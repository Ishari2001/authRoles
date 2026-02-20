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
        // ✅ If already logged, don't allow re-login
        if ($this->session->get('logged')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function register()
    {
        // ✅ Prevent logged users opening register again
        if ($this->session->get('logged')) {
            return redirect()->to('/dashboard');
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

        $name       = $this->request->getPost('name');
        $email      = $this->request->getPost('email');
        $password   = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $sponsor_id = $this->request->getPost('sponsor_id');

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email already registered');
        }

        $sponsorName = null;
        if (!empty($sponsor_id)) {
            $sponsor = $userModel->find($sponsor_id);

            if (!$sponsor) {
                return redirect()->back()->with('error', 'Invalid Sponsor ID');
            }

            $sponsorName = $sponsor['name'];
        } else {
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

        return redirect()->back()
            ->with('success', 'Registration Successful!')
            ->with('new_user_id', $newUserId)
            ->with('sponsor_id', $sponsor_id)
            ->with('sponsor_name', $sponsorName);
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
