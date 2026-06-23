<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        if (session()->get('user_id')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user  = $model->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        session()->set([
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'user_email'=> $user['email'],
        ]);

        // Update last login
        $model->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        return redirect()->to('/')->with('success', 'Welcome back, ' . $user['name'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }
}
