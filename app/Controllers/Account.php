<?php

namespace App\Controllers;

use CodeIgniter\Shield\Models\UserModel;

class Account extends BaseController
{
    // ---------- Profile ----------

    public function profileForm()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $user = auth()->user();
        $db   = db_connect();
        $row  = $db->table('users')->select('display_name, phone')->where('id', $user->id)->get()->getRowArray();

        return view('auth/profile', [
            'title'   => 'My Profile — Smokey Cocktail',
            'user'    => [
                'id'           => $user->id,
                'username'     => $user->username,
                'email'        => $user->email,
                'display_name' => $row['display_name'] ?? '',
                'phone'        => $row['phone'] ?? '',
                'created_at'   => $user->created_at,
                'last_active'  => $user->last_active,
                'groups'       => $user->getGroups(),
            ],
        ]);
    }

    public function profileSubmit()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $rules = [
            'username'     => 'required|min_length[3]|max_length[30]',
            'email'        => 'required|valid_email|max_length[255]',
            'display_name' => 'permit_empty|max_length[120]',
            'phone'        => 'permit_empty|max_length[30]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user  = auth()->user();
        $users = new UserModel();
        $db    = db_connect();

        $username    = trim((string) $this->request->getPost('username'));
        $email       = trim((string) $this->request->getPost('email'));
        $displayName = trim((string) $this->request->getPost('display_name'));
        $phone       = trim((string) $this->request->getPost('phone'));

        // Username: unique across users (except self)
        $clash = $db->table('users')->where('username', $username)->where('id !=', $user->id)->countAllResults();
        if ($clash > 0) {
            return redirect()->back()->withInput()->with('error', 'That username is already taken.');
        }

        // Email: unique across auth_identities (except self)
        $emailClash = $db->table('auth_identities')
            ->where('type', 'email_password')
            ->where('secret', $email)
            ->where('user_id !=', $user->id)
            ->countAllResults();
        if ($emailClash > 0) {
            return redirect()->back()->withInput()->with('error', 'That email is already in use.');
        }

        // Save username via Shield
        $user->username = $username;
        $users->save($user);

        // Save extra profile fields directly
        $db->table('users')->where('id', $user->id)->update([
            'display_name' => $displayName ?: null,
            'phone'        => $phone ?: null,
        ]);

        // Update email on auth_identities
        $db->table('auth_identities')
            ->where('user_id', $user->id)
            ->where('type', 'email_password')
            ->update(['secret' => $email]);

        return redirect()->to(site_url('account/profile'))->with('success', 'Profile updated.');
    }

    // ---------- Password ----------

    public function changePasswordForm()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $must = (bool) (db_connect()->table('users')
            ->select('must_change_password')
            ->where('id', auth()->id())
            ->get()->getRowArray()['must_change_password'] ?? 0);

        return view('auth/change_password', [
            'title'  => 'Change Password — Smokey Cocktail',
            'forced' => $must,
        ]);
    }

    public function changePasswordSubmit()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]|max_length[255]',
            'confirm_password' => 'required|matches[new_password]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user    = auth()->user();
        $current = (string) $this->request->getPost('current_password');
        $new     = (string) $this->request->getPost('new_password');

        $creds  = ['email' => $user->email, 'password' => $current];
        $result = auth()->check($creds);
        if (!$result->isOK()) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        if ($current === $new) {
            return redirect()->back()->with('error', 'New password must be different from the current password.');
        }

        $users = new UserModel();
        $user->setPassword($new);
        $users->save($user);

        db_connect()->table('users')->where('id', $user->id)->update(['must_change_password' => 0]);

        $dest = $user->inGroup('super_admin') || $user->inGroup('inventory_manager')
            ? site_url('admin')
            : site_url('portal');

        return redirect()->to($dest)->with('success', 'Password updated. Welcome to Smokey Cocktail.');
    }
}
