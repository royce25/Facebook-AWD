<?php

namespace AHWEBDEV\Wordpress\PluginBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * AHWEBDEVWordpressPluginExtension
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Bundle
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class AdminCompilerPass implements CompilerPassInterface
{

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ahwebdev_wordpress_plugin.admin.pool')) {
            return;
        }
        $definition = $container->getDefinition('ahwebdev_wordpress_plugin.admin.pool');
        $taggedServices = $container->findTaggedServiceIds('ahwebdev_wordpress_plugin.admin.page');

        $definitionsToPass = array();
        foreach ($taggedServices as $id => $attributes) {
            $definitionsToPass[$id] = $container->getDefinition($id);
        }

        //replace the set of admin page service
        if (count($definition->getArguments())) {
            $definition->replaceArgument(0, $definitionsToPass);
        } else {
            $definition->addArgument($definitionsToPass);
        }
    }

}
