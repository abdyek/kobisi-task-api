<?php

$config = new Kobisi\CompanyService\Core\Config();

$config->setSecret('bu_bir_secret');
$config->setAuthorization([
    'ExampleController' => [
        'create' => ['guest']
    ]
]);

$config->setDatabase([
    'dsn' => 'mysql:host=127.0.0.1:3306;dbname=kobisi_task_api',
    'username' => 'root',
    'password' => ''
]);
