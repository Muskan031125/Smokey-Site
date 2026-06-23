<?php

namespace App\Controllers;

/**
 * Role-Based login redirect.
 * After Shield authenticates, it sends user here. We then redirect based on user's group(s):
 *   super_admin / inventory_manager / viewer  → /admin
 *   anyone else (customer)                    → /shop
 */
class AfterLogin extends BaseController
{
    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(site_url('login'));
        }

        $user = auth()->user();

        // Admin roles → admin panel
        $adminGroups = ['super_admin', 'inventory_manager', 'viewer'];
        foreach ($adminGroups as $g) {
            if ($user->inGroup($g)) {
                return redirect()->to(site_url('admin'));
            }
        }

        // Default: customer → shop
        return redirect()->to(site_url('shop'));
    }
}
