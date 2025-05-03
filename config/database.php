<?php

return [
    'connections' => [
        'points-of-interest' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_HOST', 'localhost'),
            'port' => env('MONGO_PORT', 27017),
            'database' => env('MONGO_DB_POINTS_OF_INTEREST', 'points-of-interest'),
            'username' => env('MONGO_USERNAME', 'desafios'),
            'password' => env('MONGO_PASSWORD', 'desafios'),
            'authSource' => env('MONGO_AUTH_SOURCE', 'admin'),
            'authMechanism' => env('MONGO_AUTH_MECHANISM', 'SCRAM-SHA-256'),
        ],
        'url-shortener' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_HOST', 'localhost'),
            'port' => env('MONGO_PORT', 27017),
            'database' => env('MONGO_DB_URL_SHORTENER', 'url-shortener'),
            'username' => env('MONGO_USERNAME', 'desafios'),
            'password' => env('MONGO_PASSWORD', 'desafios'),
            'authSource' => env('MONGO_AUTH_SOURCE', 'admin'),
            'authMechanism' => env('MONGO_AUTH_MECHANISM', 'SCRAM-SHA-256'),
        ],
    ],
    
];