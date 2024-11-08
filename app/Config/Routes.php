<?php

use App\Controllers\AuthController;
use App\Controllers\ProductsController;
use CodeIgniter\Router\RouteCollection;



/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->post('auth/login', 'AuthController::login');

$routes->group('auth', function ($routes) {
    $routes->post('logout', 'AuthController::logout');
});

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DashboardController::index');
});

$routes->group('products', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProductsController::index');
    $routes->post('/', 'ProductsController::create');
    $routes->get('(:num)', 'ProductsController::show/$1');
    $routes->put('(:num)', 'ProductsController::update/$1');
    $routes->delete('(:num)', 'ProductsController::delete/$1');
});
