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

    $routes->get('dashboard', 'Admin::dashboard'); // ✅ FIXED

    // AJAX (for modal edit)
    $routes->post('ticket/get', 'Admin::getTicket');
    $routes->post('ticket/update', 'Admin::updateTicketAjax');
    $routes->post('ticket/delete', 'Admin::deleteTicketAjax');

    // Create ticket
    $routes->post('tickets/save', 'Admin::saveTicket');

    // Logout
    $routes->get('logout', 'Admin::logout');
});