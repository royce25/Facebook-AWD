<?php

namespace AHWEBDEV\Framework;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Controller\BackendControllerInterface;
use AHWEBDEV\Framework\Plugin\Plugin;
use Exception;
use ReflectionClass;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Container
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
abstract class Container implements \AHWEBDEV\Framework\ContainerInterface
{

    /**
     * The title
     * @var string
     */
    protected $title;

    /**
     * the slug identifier
     * @var string
     */
    protected $slug;

    /**
     * the text domain
     * @var string
     */
    protected $ptd;

    /**
     * The BackendControllerInterface instance
     *
     * @var BackendControllerInterface
     */
    protected $services;

    /**
     * All assets required to work with facebook AWD.
     *
     * @var array
     */
    protected $assets = array();

    /**
     *
     * @var array
     */
    protected $plugins = array();

    /**
     *
     * @var \AHWEBDEV\Framework\ContainerInterface
     */
    protected $container = null;

    /**
     *
     * @var boolean 
     */
    protected $apcLoaded = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->apcLoaded = extension_loaded('apc');
        $this->services = array();
    }

    /**
     * Return a service by name
     *
     * @param  string    $name
     * @return The       service
     * @throws Exception
     */
    public function get($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        if ($this->apcLoaded) {
            $content = apc_fetch($this->slug . '_' . $name);
            if ($content) {
                return $content;
            }
        }
        throw new Exception('The service name ' . $name . ' was not found', 500);
    }

    /**
     * Set a service
     *
     * @param  string                        $name
     * @param $service
     * @return \AHWEBDEV\Framework\Container
     */
    public function set($name, $service)
    {
        if ($this->apcLoaded) {
            apc_add($this->slug . '_' . $name, $service, 120);
        }
        $this->services[$name] = $service;

        return $this;
    }

    /**
     * Return the assets
     *
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set the assets
     *
     * @param  array       $assets
     * @return FacebookAWD
     */
    public function setAssets(array $assets)
    {
        $this->assets = $assets;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     *
     * @param  array                         $plugins
     * @return \AHWEBDEV\Framework\Container
     */
    public function setPlugins(array $plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * Get the title
     * @return type
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the slug
     * @return type
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the text domain
     * @return type
     */
    public function getPtd()
    {
        return $this->ptd;
    }

    /**
     * Set the title
     * @param  type                          $title
     * @return \AHWEBDEV\Framework\Container
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the slug
     * @param  type                          $slug
     * @return \AHWEBDEV\Framework\Container
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set the text domain
     * @param  type                          $slug
     * @return \AHWEBDEV\Framework\Container
     */
    public function setPtd($ptd)
    {
        $this->ptd = $ptd;

        return $this;
    }

    /**
     * The debugger
     * @param  boolean $echo
     * @return string
     */
    public function debug($echo = true)
    {
        $debug = print_r($this, true);

        if ($echo) {
            echo '<pre>' . $debug . '</pre>';
        } else {
            return '<pre>' . $debug . '</pre>';
        }
    }

    /**
     *
     * @param  string                        $name
     * @param  Plugin                        $plugin
     * @return \AHWEBDEV\Framework\Container
     */
    public function registerPlugin($name, Plugin $plugin)
    {
        $this->plugins[$name] = $plugin;

        return $this;
    }

    /**
     * Return this file name
     *
     * @return string
     */
    public function getFile($file)
    {
        $f = new ReflectionClass($file);

        return $f->getFileName();
    }

    /**
     * Get All services
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     *
     * @return type
     */
    public function getRootPath()
    {
        $reflection = new \ReflectionClass($this);
        $directory = dirname($reflection->getFileName());
        return $directory;
    }

    /**
     *
     * @return \AHWEBDEV\Framework\ContainerInterface
     */
    public function getParent()
    {
        return $this->container;
    }

    /**
     * Returns the Root container
     * @return \AHWEBDEV\Framework\ContainerInterface
     */
    public function getRoot()
    {
        $rootContainer = $this;
        while ($rootContainer->container != null) {
            $rootContainer = $rootContainer->container;
        }
        return $rootContainer;
    }

    /**
     * Return Apc interface
     */
    public function apcInterface()
    {
        include_once __DIR__ . '/apc.php';
        exit();
    }

    /**
     *
     */
    abstract public function init(\AHWEBDEV\Framework\ContainerInterface $container = null);
}
