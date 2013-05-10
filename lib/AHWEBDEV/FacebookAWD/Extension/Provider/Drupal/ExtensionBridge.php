<?php

namespace AHWEBDEV\FacebookAWD\Extension\Drupal;

use AHWEBDEV\FacebookAWD\Extension\ExtensionBridge as BaseExtensionBridge;

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
class ExtensionBridge extends BaseExtensionBridge
{
    /**
     * The defaut Extension to load
     * @var Extension
     */
    protected $extension;

    /**
     * Init call by parent constructor.
     */
    public function init()
    {
        $this->extension = new Extension($this);
        $this->facebookAWD->addExtensionBridge($this);
    }

}

?>
