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
//initialize the Extension
require_once __DIR__ . '/vendors/autoload/autoload.php';
$facebookAWD = AHWEBDEV\FacebookAWD\FacebookAWD::boot();
//wordpress boot
//init plugins
//$facebookAWD->apcInterface();
//extra debug tool
//$facebookAWD->debug(true);
