<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

/**
 * Internal users (super_admin + inventory_manager) management.
 */
class Staff extends BaseController
{
    /** Internal group names */
    protected array $groups = ['super_admin', 'inventory_manager', 'viewer'];

    public function index()
    {
        $users = new UserModel();
        $db    = db_connect();

        // Join via auth_groups_users to filter staff only
        $rows = $db->table('auth_groups_users agu')
            ->select('agu.user_id, agu.group')
            ->whereIn('agu.group', $this->groups)
            ->get()
            ->getResultArray();

        $staffIds = array_unique(array_column($rows, 'user_id'));
        $groupMap = [];
        foreach ($rows as $r) {
            $groupMap[$r['user_id']] = $r['group'];
        }

        $list = [];
        foreach ($staffIds as $id) {
            $u = $users->findById($id);
            if (!$u) continue;
            $list[] = [
                'id'          => $u->id,
                'username'    => $u->username,
                'email'       => $u->email,
                'active'      => $u->active,
                'group'       => $groupMap[$id] ?? '—',
                'last_active' => $u->last_active,
                'created_at'  => $u->created_at,
            ];
        }

        return view('admin/staff/index', [
            'title'      => 'Internal Users — Smokey Admin',
            'heading'    => 'Internal Users',
            'subheading' => 'Staff with admin access',
            'users'      => $list,
        ]);
    }

    public function create()
    {
        return view('admin/staff/form', [
            'title'   => 'New Internal User',
            'heading' => 'New Internal User',
        ]);
    }

    public function store()
    {
        $users = new UserModel();
        $audit = new AuditLogModel();

        $data = [
            'username' => trim((string) $this->request->getPost('username')),
            'email'    => trim((string) $this->request->getPost('email')),
            'password' => (string) $this->request->getPost('password'),
        ];
        $group = $this->request->getPost('group') ?: 'inventory_manager';
        if (!in_array($group, $this->groups, true)) {
            return redirect()->back()->with('error', 'Invalid role.');
        }

        try {
            $user = new User($data);
            $users->save($user);
            $user = $users->findById($users->getInsertID());
            $user->addGroup($group);
            $user->activate();
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $audit->log('staff.create', 'user', $user->id, $data['username'] . ' / ' . $group);
        return redirect()->to(site_url('admin/staff'))->with('success', 'Internal user created.');
    }

    public function changeGroup(int $id)
    {
        $users = new UserModel();
        $audit = new AuditLogModel();
        $user  = $users->findById($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Not found.');
        }

        $newGroup = $this->request->getPost('group');
        if (!in_array($newGroup, $this->groups, true)) {
            return redirect()->back()->with('error', 'Invalid group.');
        }

        foreach ($user->getGroups() as $g) {
            $user->removeGroup($g);
        }
        $user->addGroup($newGroup);

        $audit->log('staff.change_group', 'user', $id, $newGroup);
        return redirect()->back()->with('success', 'Role updated.');
    }

    public function toggleActive(int $id)
    {
        $users = new UserModel();
        $audit = new AuditLogModel();
        $user  = $users->findById($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Not found.');
        }

        $user->active = !$user->active;
        $users->save($user);

        $audit->log('staff.toggle_active', 'user', $id);
        return redirect()->back()->with('success', 'Status updated.');
    }

    public function resetPassword(int $id)
    {
        $users = new UserModel();
        $audit = new AuditLogModel();
        $user  = $users->findById($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Not found.');
        }

        $temp = $this->generateTempPassword();
        $user->setPassword($temp);
        $users->save($user);

        db_connect()->table('users')->where('id', $id)->update(['must_change_password' => 1]);

        $audit->log('staff.reset_password', 'user', $id);
        return redirect()->back()->with('success', "Temporary password for {$user->username}: {$temp} — they will be forced to change it on next login.");
    }

    protected function generateTempPassword(): string
    {
        $letters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        $digits  = '23456789';
        $symbols = '@#$%&';
        $pass = '';
        for ($i = 0; $i < 8; $i++) $pass .= $letters[random_int(0, strlen($letters) - 1)];
        $pass .= $digits[random_int(0, strlen($digits) - 1)];
        $pass .= $symbols[random_int(0, strlen($symbols) - 1)];
        return str_shuffle($pass);
    }
}
