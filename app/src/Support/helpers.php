<?php

defined('LUNA_SYSTEM') or die('Hacking attempt!');

use Luna\Support\File;

if (!function_exists('base_url')) {

    /**
     * Return or generate the baseurl
     * @global Psr\Container\ContainerInterface $container
     * @param string $uri
     * @param type $suffix
     * @return type
     */
    function base_url($uri = null, $suffix = false)
    {
        global $container;
        $settings = $container->get('settings');
        if (!empty($settings['base_url'])) {
            $base_url = $settings['base_url'];
        } else {
            $request_uri = $container->get('request')->getUri();
            $base_url = $request_uri->getScheme() . '://' . $request_uri->getHost();
        }

        if (isset($uri) && $uri !== '/') {
            if (strpos($uri, '/') !== 0) {
                $uri = '/' . $uri;
            }
            if ($suffix) {
                return $base_url . $uri . '.html';
            } else {
                return $base_url . $uri;
            }
        }

        return $base_url;
    }

}

//-----------------------------------------------------------------------------

if (!function_exists('route')) {

    function route($name, $param = [])
    {
        global $container;

        return $container->get('router')->pathFor($name, $param);
    }

}

//-----------------------------------------------------------------------------

if (!function_exists('get_option')) {
    /**
     * Get app info.
     * @global Psr\Container\ContainerInterface $container
     * @param String $key
     * @param String $default
     * @return String
     */
    function get_option($key = null, $default = false)
    {
        global $container;

        if (!isset($key)) {
            return $default;
        }

        $options = $container->get('config')['app'];

        if (isset($options[$key])) {
            return $options[$key];
        }

        return $default;


    }
}

//-----------------------------------------------------------------------------

if (!function_exists('the_title')) {

    /**
     * Generate the title
     * @param String $title
     * @param String $seperator
     * @param String $direction
     * @return String
     */
    function the_title($title = null, $seperator = '&raquo;', $direction = 'left')
    {

        $site_name = get_option('name', 'LunaSYS');
        if (isset($title)) {
            if ($direction == 'left') {
                return $title . ' ' . $seperator . ' ' . $site_name;
            } else {
                return $site_name . ' ' . $seperator . ' ' . $title;
            }
        }
        return $site_name;
    }

}

//-----------------------------------------------------------------------------

if (!function_exists('clean_cache')) {
    function clean_cache($path)
    {
        $cache_dirs = glob($path);
        foreach ($cache_dirs as $c_dir) {
            $cache_files = glob($c_dir . '/*');
            foreach ($cache_files as $c_file) {
                unlink($c_file);
            }
            rmdir($c_dir);
        }
        return;
    }
}

//-----------------------------------------------------------------------------

if (!function_exists('write_file')) {
    /**
     * Write content to file
     * @param  string $path
     * @param  string $data
     * @param  string $mode
     * @return boolean
     */
    function write_file($path, $data, $mode = 'wb')
    {
        return File::writeFile($path, $data, $mode = 'wb');
    }
}
