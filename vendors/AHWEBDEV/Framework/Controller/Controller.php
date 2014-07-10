<?php

namespace AHWEBDEV\Framework\Controller;

use AHWEBDEV\Framework\Container;
use AHWEBDEV\Framework\ContainerInterface;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BackendController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
abstract class Controller implements ControllerInterface
{

    /**
     * The parent extension of this class
     * @var Container
     */
    protected $container;

    /**
     *
     * @var String
     */
    protected $listenerResponse;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Render some content based on params.
     *
     * @param  array  $params
     * @return string
     */
    public function render($template, array $params = array())
    {
        $templateManager = $this->container->getRoot()->get('services.template_manager');
        //render the admin view
        return $templateManager->render($template, $params, false);
    }
    
    /**
     * Render some content based on params.
     *
     * @param  array  $params
     * @return string
     */
    public function isAjaxRequest()
    {
        return $this->container->getRoot()->get('services.template_manager')->isAjaxRequest();
    }

    /**
     *
     * @return string
     */
    public function getListenerResponse()
    {
        return $this->listenerResponse;
    }

    /**
     *
     * @param  string                                    $listenerResponse
     * @return \AHWEBDEV\Framework\Controller\Controller
     */
    public function setListenerResponse($listenerResponse)
    {
        $this->listenerResponse = $listenerResponse;

        return $this;
    }

    /**
     * Init the admin
     */
    abstract function init();
}
