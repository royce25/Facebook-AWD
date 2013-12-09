<?php

namespace AHWEBDEV\Framework\Controller;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BackendControllerInterface
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
interface BackendControllerInterface
{

    /**
     * Get the menu iems as array
     *
     * @return array
     */
    public function getBlockItems();
}

?>
