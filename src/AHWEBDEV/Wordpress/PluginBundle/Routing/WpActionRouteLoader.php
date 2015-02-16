<?php

namespace AHWEBDEV\Wordpress\PluginBundle\Routing;

use Symfony\Component\Config\Loader\Loader;

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
            //$route->setDefault('_wpaction', true);
        }
        return $importedRoutes;
    }

    public function supports($resource, $type = null)
    {
        return $type === 'wproute';
    }

}
