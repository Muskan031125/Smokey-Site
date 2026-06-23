<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ---------------------------------------------------------------------
// Public — no login required (landing page only)
// ---------------------------------------------------------------------
$routes->get('/', 'Home::index');

// Blog (public)
$routes->get('blog', 'Blog::index');
$routes->get('blog/(:segment)', 'Blog::show/$1');

// ---------------------------------------------------------------------
// Login-gated storefront
// ---------------------------------------------------------------------
$routes->get('new-arrivals',         'Shop::newArrivals',  ['filter' => 'session']);
$routes->get('best-sellers',         'Shop::bestSellers',  ['filter' => 'session']);
$routes->get('sale',                 'Shop::sale',         ['filter' => 'session']);
$routes->get('shop',                 'Shop::index',        ['filter' => 'session']);
$routes->get('category/(:segment)',  'Shop::category/$1',  ['filter' => 'session']);
$routes->get('product/(:any)',       'Shop::product/$1',   ['filter' => 'session']);

// Cart (login required)
$routes->get('cart',          'Cart::index',  ['filter' => 'session']);
$routes->post('cart/add',     'Cart::add',    ['filter' => 'session']);
$routes->post('cart/update',  'Cart::update', ['filter' => 'session']);
$routes->post('cart/remove',  'Cart::remove', ['filter' => 'session']);
$routes->post('cart/clear',   'Cart::clear',  ['filter' => 'session']);
$routes->get('cart/count',    'Cart::count',  ['filter' => 'session']);

// Wishlist (login required)
$routes->get('wishlist',         'Wishlist::index',  ['filter' => 'session']);
$routes->post('wishlist/toggle', 'Wishlist::toggle', ['filter' => 'session']);

// Reviews
$routes->post('reviews/submit', 'Reviews::submit');

// Checkout (login required)
$routes->get('checkout', 'Checkout::index', ['filter' => 'session']);
$routes->post('checkout/confirm', 'Checkout::confirm', ['filter' => 'session']);
$routes->get('checkout/success/(:segment)', 'Checkout::success/$1', ['filter' => 'session']);

// My orders (login required)
$routes->get('orders', 'Orders::index', ['filter' => 'session']);
$routes->get('orders/(:num)', 'Orders::show/$1', ['filter' => 'session']);

// Shield auth
service('auth')->routes($routes);
$routes->match(['get', 'head', 'post'], 'logout', '\CodeIgniter\Shield\Controllers\LoginController::logoutAction');

// RBAC login redirect — sends admins to /admin, customers to /shop
$routes->get('after-login', 'AfterLogin::index', ['filter' => 'session']);

// Account
$routes->get('account/profile',          'Account::profileForm',          ['filter' => 'session']);
$routes->post('account/profile',         'Account::profileSubmit',         ['filter' => 'session']);
$routes->get('account/change-password',  'Account::changePasswordForm',    ['filter' => 'session']);
$routes->post('account/change-password', 'Account::changePasswordSubmit',  ['filter' => 'session']);

// ---------------------------------------------------------------------
// Admin Panel
// ---------------------------------------------------------------------
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    // Categories
    $routes->get('categories',                'Admin\Categories::index');
    $routes->get('categories/create',         'Admin\Categories::create',       ['filter' => 'admin-write']);
    $routes->post('categories',               'Admin\Categories::store',         ['filter' => 'admin-write']);
    $routes->get('categories/(:num)/edit',    'Admin\Categories::edit/$1',      ['filter' => 'admin-write']);
    $routes->post('categories/(:num)',        'Admin\Categories::update/$1',    ['filter' => 'admin-write']);
    $routes->post('categories/(:num)/toggle', 'Admin\Categories::toggle/$1',   ['filter' => 'admin-write']);

    // Products
    $routes->get('products',                       'Admin\Products::index');
    $routes->get('products/create',                'Admin\Products::create',           ['filter' => 'admin-write']);
    $routes->post('products',                      'Admin\Products::store',             ['filter' => 'admin-write']);
    $routes->get('products/(:num)/edit',           'Admin\Products::edit/$1',          ['filter' => 'admin-write']);
    $routes->post('products/(:num)',               'Admin\Products::update/$1',        ['filter' => 'admin-write']);
    $routes->post('products/(:num)/toggle-stock',  'Admin\Products::toggleStock/$1',   ['filter' => 'admin-write']);
    $routes->post('products/(:num)/toggle-flag',   'Admin\Products::toggleFlag/$1',    ['filter' => 'admin-write']);
    $routes->post('products/(:num)/delete',        'Admin\Products::delete/$1',        ['filter' => 'admin-write']);

    // Media
    $routes->get('products/(:num)/media',                  'Admin\Media::index/$1');
    $routes->post('products/(:num)/media',                 'Admin\Media::upload/$1',        ['filter' => 'admin-write']);
    $routes->post('products/(:num)/media/reorder',         'Admin\Media::reorder/$1',       ['filter' => 'admin-write']);
    $routes->post('products/(:num)/media/(:num)/cover',    'Admin\Media::setCover/$1/$2',   ['filter' => 'admin-write']);
    $routes->post('products/(:num)/media/(:num)/delete',   'Admin\Media::delete/$1/$2',     ['filter' => 'admin-write']);
    $routes->post('products/(:num)/media/vimeo',           'Admin\Media::addVimeo/$1',      ['filter' => 'admin-write']);

    // Orders (CRM)
    $routes->get('orders',                    'Admin\Orders::index');
    $routes->get('orders/(:num)',             'Admin\Orders::show/$1');
    $routes->post('orders/(:num)/status',     'Admin\Orders::updateStatus/$1',  ['filter' => 'admin-write']);

    // Reviews
    $routes->get('reviews',                   'Admin\Reviews::index');
    $routes->post('reviews/(:num)/approve',   'Admin\Reviews::approve/$1',      ['filter' => 'admin-write']);
    $routes->post('reviews/(:num)/reject',    'Admin\Reviews::reject/$1',       ['filter' => 'admin-write']);
    $routes->post('reviews/(:num)/delete',    'Admin\Reviews::delete/$1',       ['filter' => 'admin-write']);

    // Blog
    $routes->get('blog',                      'Admin\Blog::index');
    $routes->get('blog/create',               'Admin\Blog::create',             ['filter' => 'admin-write']);
    $routes->post('blog',                     'Admin\Blog::store',              ['filter' => 'admin-write']);
    $routes->get('blog/(:num)/edit',          'Admin\Blog::edit/$1',            ['filter' => 'admin-write']);
    $routes->post('blog/(:num)',              'Admin\Blog::update/$1',          ['filter' => 'admin-write']);
    $routes->post('blog/(:num)/delete',       'Admin\Blog::delete/$1',          ['filter' => 'admin-write']);

    // Banners / Homepage CMS
    $routes->get('banners',                   'Admin\Banners::index');
    $routes->post('banners',                  'Admin\Banners::store',           ['filter' => 'admin-write']);
    $routes->post('banners/(:num)/delete',    'Admin\Banners::delete/$1',       ['filter' => 'admin-write']);

    // Promo codes
    $routes->get('promo-codes',               'Admin\PromoCodes::index');
    $routes->post('promo-codes',              'Admin\PromoCodes::store',        ['filter' => 'admin-write']);
    $routes->post('promo-codes/(:num)/delete','Admin\PromoCodes::delete/$1',   ['filter' => 'admin-write']);

    // Wishlists (view only)
    $routes->get('wishlists',                 'Admin\Wishlists::index');

    // Bulk Import
    $routes->get('bulk-import',               'Admin\BulkImport::index',        ['filter' => 'admin-write']);
    $routes->post('bulk-import/preview',      'Admin\BulkImport::preview',      ['filter' => 'admin-write']);
    $routes->post('bulk-import/import',       'Admin\BulkImport::import',       ['filter' => 'admin-write']);
    $routes->get('bulk-import/template',      'Admin\BulkImport::template',     ['filter' => 'admin-write']);
    $routes->post('bulk-import/upload-photos','Admin\BulkImport::uploadPhotos', ['filter' => 'admin-write']);

    // Settings (super_admin)
    $routes->get('settings',  'Admin\Settings::index',  ['filter' => 'superadmin']);
    $routes->post('settings', 'Admin\Settings::update', ['filter' => 'superadmin']);

    // Staff (super_admin)
    $routes->get('staff',                        'Admin\Staff::index',             ['filter' => 'superadmin']);
    $routes->get('staff/create',                 'Admin\Staff::create',            ['filter' => 'superadmin']);
    $routes->post('staff',                       'Admin\Staff::store',             ['filter' => 'superadmin']);
    $routes->post('staff/(:num)/group',          'Admin\Staff::changeGroup/$1',    ['filter' => 'superadmin']);
    $routes->post('staff/(:num)/toggle',         'Admin\Staff::toggleActive/$1',   ['filter' => 'superadmin']);
    $routes->post('staff/(:num)/reset-password', 'Admin\Staff::resetPassword/$1',  ['filter' => 'superadmin']);
});
