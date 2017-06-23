<?php

namespace Luna\Session;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Session Middleware
 *
 * @author leonnguyenit
 */
class SessionMiddleware
{

    /**
     * App container
     * @var ContainerInterface
     */
    protected $ci;

    /**
     * Session options
     * @var array
     */
    protected $options = [
        'sess_name' => 'Luna',
        'sess_lifetime' => 7200,
        'sess_path' => null,
        'sess_domain' => null,
        'sess_secure' => false,
        'sess_httponly' => true,
        'sess_cache_limiter' => 'nocache',
    ];

    /**
     * Session service constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $options = $this->ci->get('config')['app'];

        $keys = array_keys($this->options);
        foreach ($keys as $key) {
            if (array_key_exists($key, $options)) {
                $this->options[$key] = $options[$key];
            }
        }
    }

    /**
     * Invoke middleware
     *
     * @param  ServerRequestInterface $request PSR7 request object
     * @param  ResponseInterface $response PSR7 response object
     * @param  callable $next Next middleware callable
     *
     * @return ResponseInterface PSR7 response object
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->start();
        return $next($request, $response);
    }

    /**
     * Real Startup Session Actions
     * @return null
     */
    public function start()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return;
        }
        $options = $this->options;
        $current = session_get_cookie_params();
        $lifetime = (int)($options['sess_lifetime'] ?: $current['lifetime']);
        $path = $options['sess_path'] ?: $current['path'];
        $domain = $options['sess_domain'] ?: $current['domain'];
        $secure = (bool)$options['sess_secure'];
        $httponly = (bool)$options['sess_httponly'];
        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
        session_name($options['sess_name']);
        session_cache_limiter($options['sess_cache_limiter']);
        session_start();
    }
}
