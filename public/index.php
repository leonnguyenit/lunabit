<?php

define('LUNA_SYSTEM', true);
define('LUNA_VERSION', '0.1');
define('LUNA_BASEPATH', dirname(__FILE__));
define('LUNA_APPPATH', LUNA_BASEPATH . '/../app');
define('LUNA_THEMEPATH', LUNA_BASEPATH . '/themes');
define('LUNA_CACHEPATH', LUNA_BASEPATH . '/../cache');


define('ENVIRONMENT', isset($_SERVER['LUNASYS_ENV']) ? $_SERVER['LUNASYS_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

// Vendor Autoload
require LUNA_BASEPATH . '/../vendor/autoload.php';

// App settings and initialize
require_once LUNA_APPPATH . '/constants.php';
$app_settings = include LUNA_APPPATH . '/settings.php';
$app = new Slim\App($app_settings);
$container = $app->getContainer();

// App dependencies
require LUNA_APPPATH . '/src/dependencies.php';

// App middleware
require LUNA_APPPATH . '/src/middleware.php';

// App routes
require LUNA_APPPATH . '/src/routes.php';

// App run
$app->run();