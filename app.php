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
use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$plugin = plugin_basename(basename(__DIR__) . '/plugin.php');
if (is_plugin_active($plugin)) {

    $loader = require_once __DIR__ . '/app/bootstrap.php.cache';

    //APC
    if (extension_loaded('apc') && ini_get('apc.enabled')) {
        //exit(1);
        $apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
        $loader->unregister();
        $apcLoader->register(true);
    }

    require_once __DIR__ . '/app/AppKernel.php';
    require_once __DIR__ . '/app/AppCache.php';

    $kernel = new AppKernel('prod', false);
    $kernel->loadClassCache();
    $kernel = new AppCache($kernel);
    
    // When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
    Request::enableHttpMethodParameterOverride();

    //create the request
    $request = Request::createFromGlobals();

    //handle the request
    $response = $kernel->handle($request);

    //send the request
    $response->send();

    $kernel->terminate($request, $response);
}