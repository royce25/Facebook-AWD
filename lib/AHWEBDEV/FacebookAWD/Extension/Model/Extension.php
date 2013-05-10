<?php

namespace AHWEBDEV\FacebookAWD\Extension\Model;

use AHWEBDEV\FacebookAWD\FacebookAWD;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extension
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @packae FacebookAWD\Extension
 */
abstract class Extension
{

    /**
     * The ExtensionBridgeInterface instance
     *
     * @var ExtensionBridgeInterface
     */
    protected $extensionBridge;

    /**
     * The FacebookAWD instance
     *
     * @var FacebookAWD
     */
    protected $facebookAWD;

    /**
     * The BackendControllerInterface instance
     *
     * @var BackendControllerInterface
     */
    protected $backendController;

    /**
     * Constructor
     *
     * @param \AHWEBDEV\FacebookAWD\Extension\Model\ExtensionBridgeInterface $extensionBridge
     */
    public function __construct(ExtensionBridgeInterface $extensionBridge)
    {
        $this->extensionBridge = $extensionBridge;
        $this->facebookAWD = $this->extensionBridge->getFacebookAWD();
        $this->init();
    }

    /**
     * Get the FacebookAWD instance
     * @return FacebookAWD
     */
    public function getFacebookAWD()
    {
        return $this->facebookAWD;
    }

    /**
     * Return the ExtensionBridgeInterface instance
     * @return ExtensionBridgeInterface
     */
    public function getExtensionBridge()
    {
        return $this->extensionBridge;
    }

    /**
     * Reutrn the backend controller
     * @return \AHWEBDEV\FacebookAWD\Extension\Model\BackendControllerInterface
     */
    public function getBackendController()
    {
        return $this->backendController;
    }

    /**
     * Set the backend controller
     * @param \AHWEBDEV\FacebookAWD\Extension\Model\BackendControllerInterface $backendController
     * @return \AHWEBDEV\FacebookAWD\Extension\Model\Extension
     */
    public function setBackendController(BackendControllerInterface $backendController)
    {
        $this->backendController = $backendController;
        return $this;
    }

    /**
     * Init
     */
    protected abstract function init();
}

?>
