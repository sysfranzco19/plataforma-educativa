<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ---------------------------------------------
// AUTH
// ---------------------------------------------
$routes->post('auth/login', 'AuthController::login');
$routes->get('auth/verify', 'AuthController::verify');


// ---------------------------------------------
// ADMIN — RUTAS PROTEGIDAS
// Controlador: App\Controllers\Admin\AdminController
// ---------------------------------------------
$routes->group('admin', ['filter' => 'jwt'], function($routes) {

    // CRUD RESTful
    $routes->get('/',              'Admin\AdminController::index');
    $routes->get('show/(:num)',    'Admin\AdminController::show/$1');
    $routes->post('create',        'Admin\AdminController::create');
    $routes->put('update/(:num)',  'Admin\AdminController::update/$1');
    $routes->delete('delete/(:num)', 'Admin\AdminController::delete/$1');
});


// ---------------------------------------------
// DOCENTE — RUTAS PROTEGIDAS
// Controlador: App\Controllers\Docente\DocenteController
// ---------------------------------------------
$routes->group('docente', ['filter' => 'jwt'], function($routes) {

    // CRUD RESTful
    $routes->get('/',              'Docente\DocenteController::index');
    $routes->get('show/(:num)',    'Docente\DocenteController::show/$1');
    $routes->post('create',        'Docente\DocenteController::create');
    $routes->put('update/(:num)',  'Docente\DocenteController::update/$1');
    $routes->delete('delete/(:num)', 'Docente\DocenteController::delete/$1');
});
