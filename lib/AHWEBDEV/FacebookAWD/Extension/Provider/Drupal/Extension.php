<?php

namespace AHWEBDEV\FacebookAWD\Extension\Drupal;

use AHWEBDEV\FacebookAWD\Extension\Drupal\Controller\BackendController;
use AHWEBDEV\FacebookAWD\Extension\Extension as BaseExtension;
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
     * The FacebookAWD instance
     *
     * @var FacebookAWD
     */
    protected $facebookAWD;

    /**
     * Get the FacebookAWD instance
     * @return FacebookAWD
     */
    public function getFacebookAWD()
    {
        return $this->facebookAWD;
    }

    /**
     * Launch the extension and add functionnality to wprdoress hook
     */
    public function init()
    {
        
    }
}

?>
