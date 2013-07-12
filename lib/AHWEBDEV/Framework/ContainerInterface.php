<?php

namespace AHWEBDEV\Framework;

use AHWEBDEV\Framework\Controller\BackendControllerInterface;


/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ContainerInterface
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
interface ContainerInterface
{
    /**
     *
     * @return BackendControllerInterface $backendController
     */
    public function getBackendController();

    /**
     *
     * @param BackendControllerInterface $backendController
     */
    public function setBackendController(BackendControllerInterface $backendController);

    /**
     * Init of the framework
     */
    public function init();
}

?>
