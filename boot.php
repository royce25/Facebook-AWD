<?php

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
/**
 * This is the booter of the facebookAWD extension.
 *
 * This file will instanciate a new FacebookAWDextension Container.
 * The plugin will add hook to do init.
 * Visit http://www.facebook-awd.com/docs for more détails
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
ini_set('display_errors', true);
require_once __DIR__ . '/vendors/autoload/autoload.php';
$facebookAWD = AHWEBDEV\FacebookAWD\FacebookAWD::boot();

