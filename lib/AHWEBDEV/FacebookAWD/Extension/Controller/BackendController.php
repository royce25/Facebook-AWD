<?php

namespace AHWEBDEV\FacebookAWD\Extension\Controller;

use AHWEBDEV\FacebookAWD\Extension\Controller\Controller;
use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Controller\BackendControllerInterface;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BackendController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD\Extension
 */
abstract class BackendController extends Controller implements BackendControllerInterface
{

    /**
     * The admin menu hook references
     *
     * @var array
     */
    protected $adminMenuHooks = array();

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
     * @param type $name
     * @param type $hook
     * @return \AHWEBDEV\FacebookAWD\Extension\Controller\BackendController
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
        return $this->adminMenuHooks[$name];
    }

    /**
     * Remove an admin menu hook reference
     *
     * @param string $name
     * @return \AHWEBDEV\FacebookAWD\Extension\Controller\BackendController
     */
    public function removeAdminMenuHook($name)
    {
        unset($this->adminMenuHooks[$name]);
        return $this;
    }

    /**
     * Get the menu iems as array
     *
     * @return array
     */
    public function getMenuItems()
    {
        return array(
            'settings' => array(
                'title' => "Settings",
                'pageUrl' => FacebookAWD::PLUGIN_SLUG,
            ),
            'plugins' => array(
                'title' => "Plugins",
                'pageUrl' => FacebookAWD::PLUGIN_SLUG . '_plugins',
            )
        );
    }

}

?>
