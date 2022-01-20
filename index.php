<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'config.php';

use Buki\Router\Router;
use DI\Container;

$router = new Router;

const PREFIX = 'Kobisi\CompanyService\Controller\\';
const ROUTES = [
    [
        'method' => 'post',
        'path' => 'company/register',
        'controller' => 'CompanyController',
        'actionMethod' => 'register',
    ],
    [
        'method' => 'post',
        'path' => 'company/login',
        'controller' => 'CompanyController',
        'actionMethod' => 'login'
    ],
    [
        'method' => 'post',
        'path' => 'package/check',
        'controller' => 'PackageController',
        'actionMethod' => 'check'
    ],
    [
        'method' => 'get',
        'path' => 'package',
        'controller' => 'PackageController',
        'actionMethod' => 'showPackages'
    ],
    [
        'method' => 'post',
        'path' => 'package',
        'controller' => 'PackageController',
        'actionMethod' => 'set'
    ]
];

foreach(ROUTES as $route) {
    $router->{$route['method']}('/api/' . $route['path'], function() use ($config, $route) {
        $container = new Container;
        $controller = $container->get(PREFIX . $route['controller']);
        $controller->getEndpoint()->setConfig($config);
        $controller->run($route['actionMethod']);
    });
}

$router->run();
