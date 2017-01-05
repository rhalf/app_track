<?php
return [
    
    'default' => 'driver',
    'connections' => [
        'main' => [
            'driver'    => 'mysql',
            'host'      => '184.107.179.178',
            'database'  => 'main',
            'username'  => 'admin',
            'password'  => 'admin',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'app_',
            'strict'    => false,
        ],
        'data' => [
            'driver'    => 'mysql',
            'host'      => '184.107.179.178',
            'database'  => 'data',
            'username'  => 'admin',
            'password'  => 'admin',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'app_',
            'strict'    => false,
        ],
    ],
];