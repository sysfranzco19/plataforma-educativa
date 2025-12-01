<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('auth/login', 'AuthController::login');
$routes->get('auth/verify', 'AuthController::verify');

// Rutas protegidas con JWT
$routes->group('admin', ['filter' => 'jwt'], function($routes) {
    $routes->resource('admin');
});