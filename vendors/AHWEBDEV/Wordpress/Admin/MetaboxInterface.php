<?php

namespace AHWEBDEV\Wordpress\Admin;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * AdminMenuInterface
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD
 */
interface MetaboxInterface
{

    /**
     * @returns string
     */
    public function addMetaboxes($pageHook);
}
