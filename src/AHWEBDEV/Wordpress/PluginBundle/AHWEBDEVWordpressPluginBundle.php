<?php

namespace AHWEBDEV\Wordpress\PluginBundle;

use AHWEBDEV\Wordpress\PluginBundle\DependencyInjection\Compiler\AdminCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * AHWEBDEVWordpressPluginBundle
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Bundle
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class AHWEBDEVWordpressPluginBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AdminCompilerPass());
    }

    public function boot()
    {
        //@todo find a better way....
        //We must know if function are loaded and not if we are in wordpress env.
        //if this application is a plugin of wordpress and if we call the plugin directly
        //we are in a wordpress env, but wp functions are not loaded
        /*if (!function_exists('do_action')) {
            require_once('/Users/alexhermann/Sites/Ahwebdev/facebookAWD/wp-blog-header.php');
        }*/
        $this->container->get('ahwebdev_wordpress_plugin.admin.manager')->boot();
    }

    public function mytest()
    {
        echo current_action();
    }

}
