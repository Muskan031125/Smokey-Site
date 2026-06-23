<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'client';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'super_admin' => [
            'title'       => 'Super Admin',
            'description' => 'Full control: users, RBAC, settings, and inventory.',
        ],
        'inventory_manager' => [
            'title'       => 'Inventory Manager',
            'description' => 'Manages categories, products/SKUs, and media only.',
        ],
        'viewer' => [
            'title'       => 'Viewer',
            'description' => 'Read-only access to the admin console (no edits).',
        ],
        'client' => [
            'title'       => 'Client',
            'description' => 'Approved user with read-only access to the gated catalog.',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'admin.access'        => 'Can access the admin area',
        'admin.settings'      => 'Can edit site settings (gold rate, branding)',
        'users.manage'        => 'Can approve/reject/manage clients and staff',
        'categories.manage'   => 'Can create/edit/disable categories',
        'products.manage'     => 'Can create/edit/disable SKUs',
        'media.manage'        => 'Can upload/delete product media',
        'catalog.view'        => 'Can view the gated client catalog',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'super_admin' => [
            'admin.*',
            'users.*',
            'categories.*',
            'products.*',
            'media.*',
            'catalog.*',
        ],
        'inventory_manager' => [
            'admin.access',
            'categories.manage',
            'products.manage',
            'media.manage',
            'catalog.view',
        ],
        'viewer' => [
            'admin.access',
            'catalog.view',
        ],
        'client' => [
            'catalog.view',
        ],
    ];
}
