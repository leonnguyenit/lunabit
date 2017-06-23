<?php

namespace Luna\Controllers\Admin;

use Luna\Core\AdminController;
use Luna\Models\Option;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dashboard extends AdminController
{
    /**
     * Controller Constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
        $this->moduleInfo();
    }

    /**
     * Default Invoke Controller
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param mixed $args
     * @return HTML
     */
    public function __invoke($request, $response, $args)
    {
	    $route = new \Luna\Models\Route();
	    $route->cacheFile();
	    return $response->write('LunaBIT Dashboard page');
//	    return $this->view->display($response, '/modules/' . $this->module_name . '/index', $this->data);
    }
}
