<?php

namespace AHWEBDEV\FacebookAWD\Extension\Provider\Drupal;

use AHWEBDEV\FacebookAWD\Extension\Provider\Drupal\Controller\BackendController;
use AHWEBDEV\FacebookAWD\Extension\Model\Extension as BaseExtension;
use AHWEBDEV\FacebookAWD\FacebookAWD;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BackendController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @packae FacebookAWD\Extension\Wordpress
 */
class Extension extends BaseExtension
{

    /**
     * Launch the extension and add functionnality to wprdoress hook
     */
    public function init()
    {
        $this->setBackendController(new BackendController($this));
    }

}

?>
