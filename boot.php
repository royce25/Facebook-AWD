<?php

ini_set('display_errors', true);
/**
  Plugin Name: Facebook AWD
  Plugin URI: http://facebook-awd.ahwebdev.fr
  Description: Facebook AWD will adds required extensions from facebook to your site.
  Version: 2.0-dev
  Author: AHWEBDEV
  Author URI: http://www.ahwebdev.fr
  License: Copywrite AHWEBDEV
  Text Domain: FacebookAWD
  Last modification: 22/05/2014
 */
//autoload of Facebook AWD application
require_once('autoload.php');

//initialize the Extension
$facebookAWD = new AHWEBDEV\FacebookAWD\FacebookAWD();
$facebookAWD->init();

//extra debug tool
//$facebookAWD->debug(true);
