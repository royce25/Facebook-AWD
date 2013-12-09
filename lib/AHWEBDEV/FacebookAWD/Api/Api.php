<?php

namespace AHWEBDEV\FacebookAWD\Api;

use AHWEBDEV\FacebookAWD\Model\Application;
use Facebook;

/**
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
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

?>