<?php

namespace AHWEBDEV\FacebookAWD\Api;

/**
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class AWD_facebook_api extends \Facebook
{

    /**
     * Constructor
     * @param array $options
     */
    public function __construct($options)
    {
        self::$CURL_OPTS = $options['curl_options'];
        parent::__construct(array(
            'appId' => $options['app_id'],
            'secret' => $options['app_secret_key'],
            'timeOut' => $options['timeout'],
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