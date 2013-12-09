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
     * The BackendControllerInterface instance
     *
     * @var BackendControllerInterface
     */
    protected $services;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->services = array();

        $templateManager = new TemplateManager($this);
        $this->set('services.template_manager', $templateManager);

        $optionManager = new OptionManager($this);
        $this->set('services.option_manager', $optionManager);

        $this->init();
    }

    /**
     * Return a service by name
     *
     * @param string $name
     * @return The service
     * @throws \Exception
     */
    public function get($name)
    {
        if(isset($this->services[$name])){
            return $this->services[$name];
        }
        throw new \Exception('The service name '.$name.' was not found', 500);
    }

    /**
     * Set a service
     *
     * @param string $name
     * @param $service
     * @return \AHWEBDEV\Framework\Container
     */
    public function set($name, $service)
    {
        $this->services[$name] = $service;
        return $this;
    }

    /**
     *
     */
    public abstract function init();
}

?>
