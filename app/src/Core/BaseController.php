<?php

namespace Luna\Core;

use Interop\Container\ContainerInterface;
use Luna\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * BaseController
 *
 * @author leonnguyenit
 */
abstract class BaseController
{

    /**
     * App container interface
     * @var ContainerInterface
     */
    protected $ci;

    /**
     * Luna Twig View
     * @var LunaView
     */
    protected $view;

    /**
     * Illuminate Database
     * @var object
     */
    protected $db;

    /**
     * Illuminate Schema Database
     * @var object
     */
    protected $schema;

    /**
     * Module Config
     * @var array
     */
    protected $config;

    /**
     * Passing Data
     * @var array
     */
    public $data;

    /**
     * Flash Messages
     * @var \Luna\Flash\Messages
     */
    public $flash;

    /**
     * Messages
     * @var mixed
     */
    public $messages;

    /**
     * Errors
     * @var mixed
     */
    public $errors;

    /**
     * Session Object Class
     * @var object
     */
    public $session;

    /**
     * Translator
     * @var Object
     */
    public $translator;


    /**
     * BaseController Class Constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->view = $this->ci->get('view');
        $this->db = $this->ci->get('db');
        $this->schema = $this->db->getSchemaBuilder();
        $this->config = $this->ci->get('config');
        $this->flash = $this->ci->get('flash');
        $this->session = new Session();
        $this->translator = $this->ci->get('translator');

    }

    /**
     * Abstract Default Controller Action
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     */
    abstract public function __invoke($request, $response, $args);
}
