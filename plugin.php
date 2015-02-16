<?php

/**
  Plugin Name: FacebookAWD
  Plugin URI: http://facebook-awd.ahwebdev.fr
  Description: Facebook AWD will adds required extensions from facebook to your site.
  Version: 2.0
  Author: Alexandre Hermann (AHWEBDEV) <hermann.alexandre@ahwebdev.fr>
  Author URI: http://www.ahwebdev.fr
  License: Copywrite AHWEBDEV
  Text Domain: FacebookAWD
  Last modification: 22/05/2014
 */
add_action('plugins_loaded', create_function('', 'include __DIR__ . "/' . (WP_DEBUG ? 'app_dev.php' : 'app.php') . '";'));
