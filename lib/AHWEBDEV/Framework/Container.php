<?php

namespace AHWEBDEV\Framework;

use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\Controller\BackendControllerInterface;
use AHWEBDEV\Framework\OptionManager\OptionManager;
use AHWEBDEV\Framework\TemplateManager\TemplateManager;

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
abstract class Container implements ContainerInterface
{

    /**
     *
     * @var TemplateManager
     */
    protected $templateManager;

    /**
     *
     * @var OptionManager
     */
    protected $optionManager;

    /**
     * The BackendControllerInterface instance
     *
     * @var BackendControllerInterface
     */
    protected $backendController;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Return the backend controller
     *
     * @return BackendControllerInterface
     */
    public function getBackendController()
    {
        return $this->backendController;
    }

    /**
     * Set the backend controller
     *
     * @param \AHWEBDEV\FacebookAWD\Extension\Controller\BackendControllerInterface $backendController
     * @return \AHWEBDEV\Framework\ContainerInterface
     */
    public function setBackendController(BackendControllerInterface $backendController)
    {
        $this->backendController = $backendController;
        return $this;
    }

    /**
     * Return the OptionManager
     *
     * @return OptionManager
     */
    public function getOptionManager()
    {
        return $this->optionManager;
    }

    /**
     * Set the OptionManager
     *
     * @param \AHWEBDEV\Framework\OptionManager $optionManager
     * @return \AHWEBDEV\Framework\ContainerInterface
     */
    public function setOptionManager(OptionManager $optionManager)
    {
        $this->optionManager = $optionManager;
        return $this;
    }

    /**
     * Return the TemplateManager
     *
     * @return TemplateManager
     */
    public function getTemplateManager()
    {
        return $this->templateManager;
    }

    /**
     * Set the OptionManager
     *
     * @param \AHWEBDEV\Framework\TemplateManager $templateManager
     * @return \AHWEBDEV\Framework\ContainerInterface
     */
    public function setTemplateManager(TemplateManager $templateManager)
    {
        $this->templateManager = $templateManager;
        return $this;
    }

    /**
     *
     */
    public abstract function init();
}

?>
