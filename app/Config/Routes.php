<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('login', 'Auth::index', ['filter' => 'guest']);
$routes->post('login', 'Auth::login', ['filter' => 'guest']);

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->addRedirect('/', '/archives');

    $routes->get('logout', 'Auth::logout');
    $routes->post('logout', 'Auth::logout');

    $routes->get('archives', 'Archives::index');
    $routes->get('archives/create', 'Archives::create');
    $routes->post('archives', 'Archives::store');
    $routes->get('archives/edit/(:num)', 'Archives::edit/$1');
    $routes->post('archives/update/(:num)', 'Archives::update/$1');
    $routes->post('archives/delete/(:num)', 'Archives::delete/$1');
    $routes->get('archives/file/(:num)', 'Archives::file/$1');
    $routes->get('archives/download/(:num)', 'Archives::download/$1');
    $routes->get('archives/(:num)', 'Archives::show/$1');

    $routes->get('categories', 'Categories::index');
    $routes->get('categories/create', 'Categories::create');
    $routes->post('categories', 'Categories::store');
    $routes->get('categories/edit/(:num)', 'Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Categories::update/$1');
    $routes->post('categories/delete/(:num)', 'Categories::delete/$1');
});
