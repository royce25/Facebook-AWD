<?php

namespace AHWEBDEV\FacebookAWD\Api;

use AHWEBDEV\FacebookAWD\Model\Application;
//use Facebook;

use Facebook\FacebookSession;
/*use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;*/

/*FacebookSession::setDefaultApplication('YOUR_APP_ID','YOUR_APP_SECRET');

// Use one of the helper classes to get a FacebookSession object.
//   FacebookRedirectLoginHelper
//   FacebookCanvasLoginHelper
//   FacebookJavaScriptLoginHelper
// or create a FacebookSession with a valid access token:
$session = new FacebookSession('access-token-here');

// Get the GraphUser object for the current user:

try {
  $me = (new FacebookRequest(
    $session, 'GET', '/me'
  ))->execute()->getGraphObject(GraphUser::className());
  echo $me->getName();
} catch (FacebookRequestException $e) {
  // The Graph API returned an error
} catch (\Exception $e) {
  // Some other error occurred
}*/

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
class Api extends FacebookSession
{

    /**
     * Constructor
     * @param array $options
     */
    public function __construct(Application $application)
    {
        self::setDefaultApplication('YOUR_APP_ID','YOUR_APP_SECRET');
        //self::$CURL_OPTS = array();//$options['curl_options'];
        /*parent::__construct(array(
            'appId' => $application->getId(),
            'secret' => $application->getSecretKey(),
            'timeOut' => 5000,
        ));*/
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
