<?php

namespace AHWEBDEV\Framework\Controller;

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
     * Render some content based on params.
     *
     * @param type  $template
     * @param array $params
     */
    public function render($template, array $params);

    /**
     * Boot of the controller.
     */
    public function init();

    /**
     *
     * @return string
     */
    public function getListenerResponse();

    /**
     *
     * @param  string                                    $listenerResponse
     * @return \AHWEBDEV\Framework\Controller\Controller
     */
    public function setListenerResponse($listenerResponse);
}
