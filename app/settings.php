<?php

defined('LUNA_SYSTEM') or die('Hacking attempt!');

return [
    'settings' => [
        'base_url' => '',
        // App Global Settings
        'global' => [
            'charset' => 'UTF-8',
            'name' => 'LunaBIT',
            'description' => 'A simple CMS from LunaSYS',
            'version' => '1.0',
            'theme' => 'lunabit',
            'admin_theme' => 'dashboard',
            // author
            'author_name' => 'Leon Nguyen IT',
            'author_email' => 'thanhluan12a14@gmail.com',
            // Cookie
            'cookie_prefix' => 'lunacookie',
            'cookie_domain' => '',
            'cookie_path' => '/',
            'cookie_secure' => false,
            'cookie_httponly' => false,
            // Session Options
            'sess_prefix' => 'lunasess',
            'sess_name' => 'LunaSYS_CMS',
            'sess_lifetime' => 7200,
            'sess_path' => null,
            'sess_domain' => null,
            'sess_secure' => false,
            'sess_httponly' => true,
            'sess_cache_limiter' => 'nocache'
        ],
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        // View settings
        'view' => [
            'paths' => LUNA_THEMEPATH,
            'helpers' => [
                'base_url', 'get_option', 'the_title'
            ],
            'functions_safe' => [],
            'environment' => [
                'cache' => LUNA_BASEPATH . '/../cache/twig',
                'debug' => ENVIRONMENT !== 'production',
                'autoescape' => 'html',
                'auto_reload' => true
            ]
        ],
        // Illuminate database settings
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'lunabit',
            'username' => 'lunasys',
            'password' => 'lunasys',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => 'lbv1_',
        ]
    ],
];
