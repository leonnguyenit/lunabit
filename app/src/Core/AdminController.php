<?php

namespace Luna\Core;

use Interop\Container\ContainerInterface;
use Luna\Models\Option;

/**
 * AdminController
 *
 * @author leonnguyenit
 */
abstract class AdminController extends BaseController
{

    /**
     * Theme name
     */
    public $theme_name;

    /**
     * Theme path
     */
    public $theme_path;

    /**
     * Module name
     */
    public $module_name;

    /**
     * Module title
     */
    public $module_title;

    /**
     * Module config
     */
    public $module_config;

    /**
     * AdminController constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);

        $this->theme_name = get_option('admin_theme', 'dashboard');
        $this->theme_path = '/themes/' . $this->theme_name;
        $this->data['THEME_NAME'] = $this->theme_name;
        $this->data['THEME_PATH'] = $this->theme_path;
        $this->data['ASSETS_PATH'] = $this->theme_path . '/assets';
        $this->view->setTheme($this->theme_name);

    }

    /**
     * Load Module Info
     */
    public function moduleInfo()
    {
        $class_name = strtolower(str_singular((new \ReflectionClass($this))->getShortName()));

        if (!isset($this->module_name)) {
            $this->module_name = $class_name;
        }

        if (!isset($this->module_title)) {
            $this->module_title = ucfirst(str_plural($class_name));
        }

        $this->module_config = Option::moduleConfig($this->module_name);
        $this->data['module_name'] = $this->module_name;
        $this->data['module_title'] = $this->module_title;

        // Get Flash Messages
        if ($this->flash->hasMessage('dashboard')) {
            $this->data['flash_messages'] = $this->flash->getMessages('dashboard')['dashboard'];
        }
    }
}
