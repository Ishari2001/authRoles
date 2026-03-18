<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =============================
// PUBLIC
// =============================
$routes->get('/', 'Auth::login');
$routes->get('home', 'Home::index');

// =============================
// AUTH
// =============================
$routes->get('login', 'Auth::login');
$routes->post('doLogin', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('register', 'Auth::register');
$routes->post('saveUser', 'Auth::registerSave');

$routes->get('getSponsorName', 'Auth::getSponsorName');


// =============================
// USER DASHBOARD
// =============================
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/profile', 'Dashboard::profile');


// =============================
// ADMIN LOGIN
// =============================
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::doLogin');


// =============================
// SUPER ADMIN ROUTES 👑
// =============================
$routes->group('superadmin', function($routes){

    $routes->get('dashboard', 'SuperAdmin\Dashboard::index');

    $routes->get('users', 'SuperAdmin\Users::index');

    $routes->get('tickets', 'SuperAdmin\Tickets::index');
    $routes->get('tickets/add', 'SuperAdmin\Tickets::add');
    $routes->post('tickets/save', 'SuperAdmin\Tickets::save');
    $routes->post('tickets/update', 'SuperAdmin\Tickets::update');

    $routes->get('tickets/delete/(:num)', 'SuperAdmin\Tickets::delete/$1');

    $routes->get('purchases', 'SuperAdmin\Purchases::index');

    $routes->get('commissions', 'SuperAdmin\Commissions::index');
    $routes->get('users/delete/(:num)', 'SuperAdmin\Users::delete/$1');

});


// =============================
// NORMAL ADMIN ROUTES 🧑
// =============================
$routes->group('admin', function($routes){

    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Admin only manages tickets
    $routes->get('tickets', 'Admin\Tickets::index');
    $routes->get('tickets/add', 'Admin\Tickets::add');
    $routes->post('tickets/save', 'Admin\Tickets::save');
    $routes->get('tickets/delete/(:num)', 'Admin\Tickets::delete/$1');

    // Admin can view purchases
    $routes->get('purchases', 'Admin\Purchases::index');

});