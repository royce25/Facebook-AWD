<?php

namespace AHWEBDEV\Wordpress\PluginBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

/**
 * WpActionRouteLoader
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Bundle
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class WpActionRouteLoader extends Loader
{

    public function load($resource, $type = null)
    {
        $importedRoutes = $this->import($resource, 'yaml');
        foreach ($importedRoutes as $route) {
            //$route->de
            //$wpAction = 
            $route->setDefault('_wpaction', true);
            //var_dump($route);
        }
        //$collection->addCollection($importedRoutes);
        return $importedRoutes;
    }

    public function supports($resource, $type = null)
    {
        return $type === 'wproute';
    }

}
