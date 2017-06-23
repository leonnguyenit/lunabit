<?php

defined('LUNA_SYSTEM') or die('Hacking attempt!');

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Auth Middleware
// $app->add($container->get('authmiddleware'));

// Session Middleware
$app->add($container->get('sessionmiddleware'));

// Trailling / route middleware
$app->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if (preg_match('/^\/([a-z0-9\-\_\.\/\+]+)(\/|\.html)$/i', $path, $matches)) {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath($matches[1]);

        return $next($request->withUri($uri), $response);
    }

    return $next($request, $response);
});
