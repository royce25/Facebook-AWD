<?php

namespace AHWEBDEV\Wordpress\PluginBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use AHWEBDEV\Wordpress\PluginBundle\Admin\AminPool;

/**
 * AHWEBDEVWordpressPluginExtension
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Bundle
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class AHWEBDEVWordpressPluginExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('admin.yml');

        $this->addClassesToCompile(array(
            'AHWEBDEV\\Wordpress\\PluginBundle\\Listener\\RequestListener',
            'AHWEBDEV\\Wordpress\\PluginBundle\\Controller\\WpController',
            'AHWEBDEV\\Wordpress\\PluginBundle\\Routing\\WpActionRouter',
                //'AHWEBDEV\\Wordpress\\PluginBundle\\Admin\\AminPool',
                //'AHWEBDEV\\Wordpress\\PluginBundle\\Admin\\AminManager',
                //'AHWEBDEV\\Wordpress\\PluginBundle\\Admin\\AminPage',
        ));
    }

}
