<?php

namespace AHWEBDEV\FacebookAWD\Extension\Model;

use AHWEBDEV\FacebookAWD\Extension\Model\Extension;
use AHWEBDEV\FacebookAWD\FacebookAWD;

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
 * @packae FacebookAWD\Extension
 */
abstract class BackendController implements BackendControllerInterface
{

    /**
     * The settings menu hook
     * @var string
     */
    protected $settingsMenuHook;

    /**
     * The plugins menu hook
     * @var string
     */
    protected $pluginsMenuHook;

    /**
     * the opengraph menu hook
     * @var string
     */
    protected $opengraphMenuHook;

    /**
     * The parent extension of this class
     * @var Extension
     */
    protected $extension;

    /**
     * The instance of the plugin
     * @var FacebookAWD
     */
    protected $facebookAWD;

    /**
     * Constructor
     * @param \AHWEBDEV\FacebookAWD\Extension\Model\Extension $extention
     */
    public function __construct(Extension $extention)
    {
        $this->extension = $extention;
        $this->facebookAWD = $this->extension->getFacebookAWD();
        $this->init();
    }

    /**
     * Init the admin
     */
    abstract function init();

    /**
     * Return the admin menu hook
     * @return string
     */
    public function getSettingsMenuHook()
    {
        return $this->settingsMenuHook;
    }

    /**
     * Set the admin menu hook
     * @param string
     */
    public function setSettingsMenuHook($settingsMenuHook)
    {
        $this->settingsMenuHook = $settingsMenuHook;
    }

    /**
     * Return the plugins menu hook
     * @return string
     */
    public function getPluginsMenuHook()
    {
        return $this->pluginsMenuHook;
    }

    /**
     * Set the plugins menu hook
     * @param string
     */
    public function setPluginsMenuHook($pluginsMenuHook)
    {
        $this->pluginsMenuHook = $pluginsMenuHook;
    }

    /**
     * Return the opengraph menu hook
     * @return string
     */
    public function getOpengraphMenuHook()
    {
        return $this->opengraphMenuHook;
    }

    /**
     * Set the opengraph menu hook
     * @param string
     */
    public function setOpengraphMenuHook($opengraphMenuHook)
    {
        $this->opengraphMenuHook = $opengraphMenuHook;
    }

}

?>
