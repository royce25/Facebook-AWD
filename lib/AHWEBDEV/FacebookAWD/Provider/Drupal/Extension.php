<?php

namespace AHWEBDEV\FacebookAWD\Provider\Drupal;

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);



use AHWEBDEV\FacebookAWD\Provider\Drupal\Controller\BackendController;
use AHWEBDEV\FacebookAWD\Extension\Extension as BaseExtension;

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
 * @package FacebookAWD\Extension\Wordpress
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
