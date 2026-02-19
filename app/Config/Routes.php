<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->get('/', 'Home::index');


$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/doLogin', 'Auth::doLogin');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');


$routes->get('/register', 'Auth::register');
$routes->post('/saveUser', 'Auth::registerSave');

$routes->get('/getSponsorName', 'Auth::getSponsorName');
