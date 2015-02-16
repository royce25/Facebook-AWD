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
        //do not start the wp if we are under cli call
        if (function_exists('do_action')) {
            $this->container->get('ahwebdev_wordpress_plugin.admin.manager')->boot();
        }
    }

    public function mytest()
    {
        echo current_action();
    }

}
