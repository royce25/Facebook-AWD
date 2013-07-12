<?php

namespace AHWEBDEV\Framework\Controller;

use AHWEBDEV\Framework\Container;
use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\Controller\ControllerInterface;

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
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->init();
    }

    /**
     * Render some content based on params.
     *
     * @param array $params
     * @return string
     */
    public function render($template, array $params)
    {
        $templateManager = $this->container->getTemplateManager();
        //render the admin view
        return $templateManager->render($template, $params, false);
    }

    /**
     * Init the admin
     */
    abstract function init();
}

?>
