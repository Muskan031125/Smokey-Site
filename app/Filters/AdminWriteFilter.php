<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Blocks viewers from write routes in the admin area.
 * Allows super_admin and inventory_manager; denies viewer.
 */
class AdminWriteFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = auth()->user();
        if ($user && $user->inGroup('viewer') && !$user->inGroup('super_admin') && !$user->inGroup('inventory_manager')) {
            return redirect()->to('/admin')->with('error', 'View-only access: edits are not permitted.');
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
