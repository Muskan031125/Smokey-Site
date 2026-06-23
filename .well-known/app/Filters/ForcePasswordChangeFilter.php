<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Redirects any logged-in user with must_change_password=1 to the change password page.
 */
class ForcePasswordChangeFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!auth()->loggedIn()) {
            return null;
        }

        $user = auth()->user();
        $row = db_connect()->table('users')->select('must_change_password')->where('id', $user->id)->get()->getRowArray();
        if (empty($row) || (int) $row['must_change_password'] !== 1) {
            return null;
        }

        // Allow the change-password page itself and logout, everything else redirects
        $path = $request->getUri()->getPath();
        $allowed = ['account/change-password', 'logout'];
        foreach ($allowed as $a) {
            if (str_contains($path, $a)) {
                return null;
            }
        }

        return redirect()->to(site_url('account/change-password'))
            ->with('error', 'Please set a new password before continuing.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
