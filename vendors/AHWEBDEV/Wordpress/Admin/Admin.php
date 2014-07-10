<?php

namespace AHWEBDEV\Wordpress\Admin;

use AHWEBDEV\Framework\ContainerInterface;

/**
 * Description of Admin
 *
 * @author alexhermann
 */
abstract class Admin implements \AHWEBDEV\Wordpress\Admin\AdminInterface
{

    /**
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * The admin menu hook references
     *
     * @var array
     */
    protected $adminMenuHooks = array();

    /**
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get the admin menu hook references
     *
     * @return array
     */
    public function getAdminMenuHooks()
    {
        return $this->adminMenuHooks;
    }

    /**
     * Set the admin menu hook references
     *
     * @param string
     */
    public function setAdminMenuHooks(array $adminMenuHooks)
    {
        $this->adminMenuHooks = $adminMenuHooks;

        return $this;
    }

    /**
     * Add an admin menu hook references
     *
     * @param  string                                  $name
     * @param  callback                                $hook
     * @return AHWEBDEV\Wordpress\Admin\AdminInterface
     */
    public function addAdminMenuHook($name, $hook)
    {
        $this->adminMenuHooks[$name] = $hook;

        return $this;
    }

    /**
     * Get an admin menu hook reference
     *
     * @return array
     */
    public function getAdminMenuHook($name)
    {
        if (isset($this->adminMenuHooks[$name])) {
            return $this->adminMenuHooks[$name];
        }

        return false;
    }

    /**
     * Remove an admin menu hook reference
     *
     * @param  string                                  $name
     * @return \AHWEBDEV\FacebookAWD\Admin\Admin\Admin
     */
    public function removeAdminMenuHook($name)
    {
        unset($this->adminMenuHooks[$name]);

        return $this;
    }

    /**
     *
     */
    public function registerAssets()
    {
        $assets = $this->container->getAssets();
        print_r($assets);
        foreach ($assets as $type => $files) {
            foreach ($files as $fileName => $path) {
                $media = 'all';
                $deps = array();
                if ($type === 'script') {
                    $deps = array('jquery');
                    $media = true;
                }
                call_user_func_array('wp_register_' . $type, array($fileName, $path, $deps, null, $media));
            }
        }
    }

    
    abstract public function init();
}
