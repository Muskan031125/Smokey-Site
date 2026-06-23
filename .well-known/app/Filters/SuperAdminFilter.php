<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * super_admin-only (for Users, Settings, RBAC).
 */
class SuperAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Please sign in to continue.');
        }

        if (!auth()->user()->inGroup('super_admin')) {
            return redirect()->to('/admin')->with('error', 'Super admin access required.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
