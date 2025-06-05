<?php

return [
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];
