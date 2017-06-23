<?php

namespace Luna\Core;

use Interop\Container\ContainerInterface;

/**
 * Front Site base controller
 *
 * @author leonnguyenit
 */
abstract class SiteController extends BaseController
{

    /**
     * Front site theme name
     *
     * @var string
     */
    public $theme_name;

    /**
     * Front site theme path
     *
     * @var string
     */
    public $theme_path;

    /**
     * SiteController Constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
        $this->theme_name = get_option('theme', 'microcms');
        $this->theme_path = '/themes/' . $this->theme_name;
        $this->data['THEME_NAME'] = $this->theme_name;
        $this->data['THEME_PATH'] = $this->theme_path;
        $this->data['ASSETS_PATH'] = $this->theme_path . '/assets';
        $this->view->setTheme($this->theme_name);
    }
}
