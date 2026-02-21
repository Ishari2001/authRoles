<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->get('/home', 'Home::index');


$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/doLogin', 'Auth::doLogin');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');


$routes->get('/register', 'Auth::register');
$routes->post('/saveUser', 'Auth::registerSave');

$routes->get('/getSponsorName', 'Auth::getSponsorName');


// Admin Auth
$routes->get('/admin/login', 'Admin::login');
$routes->post('/admin/login', 'Admin::doLogin');
$routes->get('/admin/logout', 'Admin::logout');

// Admin Panel
$routes->get('/admin/dashboard', 'Admin::dashboard');

$routes->get('/admin/tickets', 'Admin::tickets');
$routes->get('/admin/tickets/add', 'Admin::addTicket');
$routes->post('/admin/tickets/save', 'Admin::saveTicket');

$routes->post('/admin/ticket/get', 'Admin::getTicket');
$routes->post('/admin/ticket/update', 'Admin::updateTicketAjax');
$routes->post('/admin/ticket/delete', 'Admin::deleteTicketAjax');