<?php

namespace AHWEBDEV\Framework\Controller;

use AHWEBDEV\Framework\ContainerInterface;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ControllerInterface
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
interface ControllerInterface
{
    /**
     *
     * @param \AHWEBDEV\Framework\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container);

    /**
     * Render some content based on params.
     *
     * @param type $template
     * @param array $params
     */
    public function render($template, array $params);

    /**
     * Boot of the controller.
     */
    public function init();
}

?>
