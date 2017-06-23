<?php

namespace Luna\Controllers;

use Luna\Core\SiteController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Home extends SiteController
{
    /**
     * Controller Constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
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
    	return $response->write($this->translator->trans('messages.system', ['app_name' => get_option('name')]));
//	    return $this->view->display($response, '/modules/home/home', $this->data);
    }
}
