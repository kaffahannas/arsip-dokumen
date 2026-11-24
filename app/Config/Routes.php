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
});
