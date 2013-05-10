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
abstract class ExtensionBridge implements ExtensionBridgeInterface
{

    /**
     *
     * @var FacebookAWD
     */
    protected $facebookAWD;

    /**
     *
     * @param FacebookAWD $facebookAWD
     */
    public final function __construct()
    {
        $this->facebookAWD = new FacebookAWD();
        $this->init();
    }

    /**
     *
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    public function getFacebookAWD()
    {
        return $this->facebookAWD;
    }

    /**
     *
     * @param \AHWEBDEV\FacebookAWD\FacebookAWD $facebookAWD
     */
    public function setFacebookAWD(FacebookAWD $facebookAWD)
    {
        $this->facebookAWD = $facebookAWD;
    }

    /**
     *
     */
    abstract public function init();
}

?>
