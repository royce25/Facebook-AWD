<?php

namespace AHWEBDEV\Wordpress\Admin;

use AHWEBDEV\Framework\ContainerInterface;

/**
 * Description of Admin
 *
 * @author alexhermann
 */
interface AdminInterface
{

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container);

    /**
     * Get the admin menu hook references
     *
     * @return array
     */
    public function getAdminMenuHooks();

    /**
     * Set the admin menu hook references
     *
     * @param string
     */
    public function setAdminMenuHooks(array $adminMenuHooks);

    /**
     * Add an admin menu hook references
     *
     * @param  string                                   $name
     * @param  callback                                 $hook
     * @return \AHWEBDEV\Wordpress\Admin\AdminInterface
     */
    public function addAdminMenuHook($name, $hook);

    /**
     * Get an admin menu hook reference
     *
     * @return array
     */
    public function getAdminMenuHook($name);

    /**
     * Remove an admin menu hook reference
     *
     * @param  string                                   $name
     * @return \AHWEBDEV\Wordpress\Admin\AdminInterface
     */
    public function removeAdminMenuHook($name);

    /**
     * Register assets using wp_register_(script|style)
     */
    public function registerAssets();

    /**
     * Init the admin
     */
    public function init();
}
