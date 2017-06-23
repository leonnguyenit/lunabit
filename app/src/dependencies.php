<?php

defined('LUNA_SYSTEM') or die('Hacking attempt!');

// Illuminate Database Service
$container['db'] = function ($c) {
    $settings = $c->get('settings');
    $container = new Illuminate\Container\Container();
    $connFactory = new \Illuminate\Database\Connectors\ConnectionFactory($container);
    $conn = $connFactory->make($settings['db']);
    $resolver = new \Illuminate\Database\ConnectionResolver();
    $resolver->addConnection('default', $conn);
    $resolver->setDefaultConnection('default');
    \Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);

    return $conn;
};

// Config service
$container['config'] = function ($c) {
    $settings = $c->get('settings');
    $db = $c->get('db');
    $schema = $db->getSchemaBuilder();

    $config['app'] = $settings['global'];

    if ($schema->hasTable('options')) {
        $all_configs = $db->table('options')->where('autoload', true)->get();

        foreach ($all_configs as $item) {
            $config['app'][$item->name] = $item->value;
        }
    }

    return $config;
};

// Session service
// $container['authmiddleware'] = function ($c) {
//     return new Luna\Auth\AuthMiddleware($c);
// };

// Session service
$container['sessionmiddleware'] = function ($c) {
    return new Luna\Session\SessionMiddleware($c);
};

// Translation container
$container['translator'] = function ($c) {
    // Register the English translator 'en'
    $translator = new Illuminate\Translation\Translator(new Illuminate\Translation\FileLoader(new Illuminate\Filesystem\Filesystem(), LUNA_BASEPATH . '/../lang'), 'en');
    // setLocal for new location
    $translator->setLocale('en');
    $translator->setFallback('en');
    return $translator;
};

// View service
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Luna\Views\Twig($settings['view']);
    $view->getTwig()->addExtension(new \Luna\Translation\TranslationExtension($c->get('translator')));
    return $view;
};

/*
 * Breadcrumbs Services
 */
//$container['breadcrumbs'] = function ($c) {
//    return new Luna\Breadcrumbs\Breadcrumbs($c);
//};

/*
 * Add Flash Messages Services
 */
$container['flash'] = function ($c) {
    return new Luna\Flash\Messages();
};

/*
 * Not found 404 Dependencies
 */
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']->withRedirect('/not-found');
    };
};
