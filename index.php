<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'config.php';

use DI\Container;

$container = new Container();

$controller = $container->get('Kobisi\CompanyService\Controller\ExampleController');

$controller->getEndpoint()->setConfig($config);

$controller->run('create');
