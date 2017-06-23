<?php

namespace Luna\Views;

use Interop\Container\ContainerInterface;
use Luna\Translation\TranslationExtension;
use Psr\Http\Message\ResponseInterface;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use Twig_LoaderInterface;
use Twig_SimpleFunction;

/**
 * LunaCMS: Twig Template Engine Libraries
 *
 * @author leonnguyenit
 * @license MIT
 * @copyright (c) 2017, Leon Nguyen IT
 */
class Twig
{
    /**
     * @var ContainerInterface
     */
    protected $ci;

    /**
     * @var array Paths to Twig templates
     */
    private $paths = [];

    /**
     * @var array Twig Environment Options
     * @see http://twig.sensiolabs.org/doc/api.html#environment-options
     */
    private $config = [];

    /**
     * @var array Helper functions to add to Twig
     */
    private $helpers = [
        'base_url', 'site_url', 'trans', '__'
    ];

    /**
     * @var array Functions with `is_safe` option
     * @see http://twig.sensiolabs.org/doc/advanced.html#automatic-escaping
     */
    private $functions_safe = [
    ];

    /**
     * @var bool Whether functions are added or not
     */
    private $functions_added = false;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * Load view from theme directory
     * @var String
     */
    public $theme_name = null;


    public function __construct($params)
    {

        !isset($params['environment']) or $this->config = $params['environment'];


        if (isset($params['helpers'])) {
            $this->helpers = array_unique(
                array_merge($this->helpers, $params['helpers'])
            );
            unset($params['functions']);
        }
        if (isset($params['functions_safe'])) {
            $this->functions_safe = array_unique(
                array_merge($this->functions_safe, $params['functions_safe'])
            );
            unset($params['functions_safe']);
        }
        if (isset($params['paths'])) {
            $this->paths = $params['paths'];
            unset($params['paths']);
        } else {
            $this->paths = [LUNA_THEMEPATH];
        }

        $this->loader = new Twig_Loader_Filesystem($this->paths);
        $this->twig = new Twig_Environment($this->loader, $this->config);

        if ($this->config['debug']) {
            $this->twig->addExtension(new Twig_Extension_Debug());
        }

        $this->addFunctions();
    }

    /**
     * Add all functions supports
     */
    protected function addFunctions()
    {
        // Runs only once
        if ($this->functions_added) {
            return;
        }
        // as is functions
        foreach ($this->helpers as $function) {
            if (function_exists($function)) {
                $this->twig->addFunction(
                    new Twig_SimpleFunction(
                        $function,
                        $function
                    )
                );
            }
        }
        // safe functions
        foreach ($this->functions_safe as $function) {
            if (function_exists($function)) {
                $this->twig->addFunction(
                    new Twig_SimpleFunction(
                        $function,
                        $function,
                        ['is_safe' => ['html']]
                    )
                );
            }
        }
        // customized functions
        if (function_exists('anchor')) {
            $this->twig->addFunction(
                new Twig_SimpleFunction(
                    'anchor',
                    [$this, 'safeAnchor'],
                    ['is_safe' => ['html']]
                )
            );
        }
        $this->functions_added = true;
    }

    /**
     * Set Twig loader
     */
    protected function setLoader($loader)
    {
        $this->loader = $loader;
    }

    /**
     * Return Twig loader
     *
     * @return Twig_LoaderInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Registers a Global
     *
     * @param string $name The global name
     * @param mixed $value The global value
     */
    public function addGlobal($name, $value)
    {
        $this->twig->addGlobal($name, $value);
    }

    /**
     * Renders Twig Template and Set Output
     *
     * @param string $view Template filename without `.twig`
     * @param array $params Array of parameters to pass to the template
     */
    public function display(ResponseInterface $response, $view, $params = [])
    {

        $response->getBody()->write($this->render($view, $params));

        return $response;
    }

    /**
     * Renders Twig Template and Returns as String
     *
     * @param string $view Template filename without `.twig`
     * @param array $params Array of parameters to pass to the template
     * @return string
     */
    public function render($view, $params = [])
    {
        $view_path = isset($this->theme_name) ? '@' . $this->theme_name . $view . '.twig' : $view . '.twig';
        return $this->twig->render($view_path, $params);
    }

    /**
     * @param string $uri
     * @param string $title
     * @param array $attributes [changed] only array is acceptable
     * @return string
     */
    public function safeAnchor($uri = '', $title = '', $attributes = [])
    {
        $uri = html_escape($uri);
        $title = html_escape($title);
        $new_attr = [];
        foreach ($attributes as $key => $val) {
            $new_attr[html_escape($key)] = html_escape($val);
        }
        return anchor($uri, $title, $new_attr);
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Set theme path
     */
    public function setTheme($theme_name = null)
    {
        $this->theme_name = $theme_name;
        $this->loader->addPath(LUNA_THEMEPATH . '/' . $this->theme_name, $this->theme_name);
    }
}
