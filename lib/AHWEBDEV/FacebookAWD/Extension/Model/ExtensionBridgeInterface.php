<?php

namespace AHWEBDEV\FacebookAWD\Extension\Model;

use AHWEBDEV\FacebookAWD\FacebookAWD;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ExtensionBridge
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @packae FacebookAWD\Extension
 */
interface ExtensionBridgeInterface
{
    /**
     * Consctuctor
     *
     * @param \AHWEBDEV\FacebookAWD\FacebookAWD $facebookAWD
     */
    public function __construct();

    /**
     * This method should do the init of the extension depending on the platform/Cms/Cmf
     */
    public function init();

    /**
     * Get the FacebookAWD instance
     */
    public function getFacebookAWD();

    /**
     * Set the FacebookAWD instance
     *
     * @param \AHWEBDEV\FacebookAWD\FacebookAWD $facebookAWD
     */
    public function setFacebookAWD(FacebookAWD $facebookAWD);
}

?>
