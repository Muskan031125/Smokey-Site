<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Allows only logged-in users in super_admin or inventory_manager groups.
 * Redirects everyone else to login.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Please sign in to continue.');
        }

        $user = auth()->user();
        if (!$user->inGroup('super_admin') && !$user->inGroup('inventory_manager') && !$user->inGroup('viewer')) {
            return redirect()->to('/portal')->with('error', 'You do not have admin access.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
