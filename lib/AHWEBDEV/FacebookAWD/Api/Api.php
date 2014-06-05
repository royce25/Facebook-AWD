<?php

namespace AHWEBDEV\FacebookAWD\Api;

use AHWEBDEV\FacebookAWD\Model\Application;
use Facebook;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Api
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD
 */
class Api extends Facebook
{

    /**
     * Constructor
     * @param array $options
     */
    public function __construct(Application $application)
    {
        //self::$CURL_OPTS = array();//$options['curl_options'];
        parent::__construct(array(
            'appId' => $application->getId(),
            'secret' => $application->getSecretKey(),
            'timeOut' => 5000,
        ));
    }

    /**
     * Return the application Access Token
     * @return string
     */
    public function getApplicationAccessToken()
    {
        return $this->appId . '|' . $this->appSecret;
    }

}
