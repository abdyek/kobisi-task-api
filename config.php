<?php

$config = new Kobisi\CompanyService\Core\Config();

$config->setSecret('bu_bir_secret');
$config->setAuthorization([
    'CompanyController' => [
        'register' => ['guest'],
        'login' => ['guest']
    ],
    'PackageController' => [
        'showAll' => ['authenticated'],
        'set' => ['authenticated'],
        'check' => ['authenticated']
    ]
]);

$config->setRequiredMap([
    'CompanyController' => [
        'register' => [
            'site_url' => [
                'type' => 'str',
                'limits' => [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            'name' => [
                'type' => 'str',
                'limits' => [
                    'min' => 1,
                    'max' => 50
                ]
            ],
            'last_name' => [
                'type' => 'str',
                'limits' => [
                    'min' => 1,
                    'max' => 50
                ]
            ],
            'company_name' => [
                'type' => 'str',
                'limits' => [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            'email' => [
                'type' => 'email',
                'limits' => [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            'password' => [
                'type' => 'str',
                'limits' => [
                    'min' => 4,
                    'max' => 50
                ]
            ]
        ],
        'login' => [
            'email' => [
                'type' => 'email',
                'limits' => [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            'password' => [
                'type' => 'str',
                'limits' => [
                    'min' => 4,
                    'max' => 50
                ]
            ]
        ]
    ],
    'PackageController' => [
        'set' => [
            'company_id' => [
                'type' => 'int',
                'limits' => [
                    'min' => 1,
                    'max' => 11
                ]
            ],
            'package_id' => [
                'type' => 'int',
                'limits' => [
                    'min' => 1,
                    'max' => 11
                ]
            ]
        ],
        'check' => [
            'token' => [
                'type' => 'str',
                'limits' => [
                    'min' => 1,
                    'max' => 1000
                ]
            ]
        ]
    ]
]);

$config->setDatabase([
    'dsn' => 'mysql:host=127.0.0.1:3306;dbname=kobisi_task_api',
    'username' => 'root',
    'password' => ''
]);
