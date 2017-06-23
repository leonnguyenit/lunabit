<?php

namespace Luna\Auth;

use Luna\Session\Session;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * AuthMiddleware
 *
 * User authenticate and privileges
 *
 * @author leonnguyenit
 */
class AuthMiddleware
{

    /**
     * Container
     * @var ContainerInterface
     */
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
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

        $flash = $this->ci->get('flash');

        $uri = $request->getUri();
        $path = $uri->getPath();
        $session = new Session();

        $user_session = $session->get('user', FALSE);

        if ($path != '/login' && !$user_session) {
            return $response->withRedirect('/login');
        }

        if (preg_match('/active|deactive|promote/i', $path, $matches)) {
            if ($user_session['perm'] !== LUNA_PERMISSION_ADMIN) {
                $flash->addMessage('dashboard', array('type' => 'error', 'code' => 400, 'message' => 'Not enough privileges. You must be an administrator to do that action.'));
                if ($request->isXhr()) {
                    return $response->withJson(['status' => 405], 200);
                }
                return $response->withRedirect('/');
            }
        }

        if (preg_match('/edit|add|export|delete/i', $path, $matches)) {
            if (!in_array($user_session['perm'], [LUNA_PERMISSION_ADMIN, LUNA_PERMISSION_MANAGER])) {
                $flash->addMessage('dashboard', array('type' => 'error', 'code' => 400, 'message' => 'Not enough privileges. You must be a Manager or an Administrator to do that action.'));
                if ($request->isXhr()) {
                    return $response->withJson(['status' => 405], 200);
                }
                return $response->withRedirect('/');
            }
        }

        return $next($request, $response);
    }

}
