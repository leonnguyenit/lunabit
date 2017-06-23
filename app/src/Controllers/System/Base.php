<?php

namespace Luna\Controllers\System;

use Luna\Core\SystemController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Base System Controller
 *
 * @author leonnguyenit
 */
class Base extends SystemController
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
        echo $this->translator->trans('messages.system', ['app_name' => get_option('name')]);
    }
}
