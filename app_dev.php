<?php

/**
 * This is the booter of the facebookAWD extension.
 *
 * This file will instanciate a new FacebookAWD extension Container.
 * The plugin will add hook to do init.
 * Visit http://www.facebook-awd.com/docs for more détails
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
ini_set('display_errors', 1);

//use Symfony\Component\ClassLoader\ApcClassLoader;

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

//if (is_plugin_active($plugin)) {

$loader = require_once __DIR__ . '/app/bootstrap.php.cache';
//$loader = require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/AppKernel.php';
Debug::enable();
//require_once __DIR__ . '/app/AppCache.php';
//APC
/* if (extension_loaded('apc') && ini_get('apc.enabled')) {
  $apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
  $loader->unregister();
  $apcLoader->register(true);
  } */

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
//create the request
//$path = str_replace($request->getBaseUrl(), "", $request->getPathInfo());
//handle the request
//send the request
//if (!is_admin()) {
//    $response->send();
//    $kernel->terminate($request, $response);
//exit();
//}else{
//if we are in wordpress
/* $responseRequired = true;
  if (defined('ABSPATH')) {
  //include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  //$plugin = plugin_basename(basename(__DIR__) . '/plugin.php');
  if (defined('WP_ADMIN') || current_action() == "plugins_loaded") {
  $responseRequired = false;
  }
  } */
//var_dump(defined('WP_ADMIN') || current_action() == "plugins_loaded");
//if ($responseRequired) {


$wordpressPath = '/Users/alexhermann/Sites/Ahwebdev/facebookAWD';

//call only if the root is not inside wordpress
//require_once($wordpressPath . '/wp-blog-header.php');
//if we come directly from this file parse the request·

if (!function_exists('add_action')) {
    require_once('/Users/alexhermann/Sites/Ahwebdev/facebookAWD/wp-blog-header.php');

    $sf2request = Request::createFromGlobals();
    $response = $kernel->handle($sf2request);
    $response->send();
    $kernel->terminate($sf2request, $response);
} else {
    $kernel->boot();
}
//var_dump(is_object($sf2request));
//var_dump(is_string($request));
//var_dump($response);


//} else {
//  $kernel->boot();
//}
//}