<?php

/**
 * Facebook AWD Application Model
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */

namespace AHWEBDEV\Framework\Plugin;

use AHWEBDEV\Framework\Container as BaseContainer;
use AHWEBDEV\Framework\ContainerInterface;

abstract class Plugin extends BaseContainer
{
    /**
     *
     * @param ContainerInterface $container
     */
    public function init(ContainerInterface $container = null)
    {
        if ($container) {
            $this->container = $container;
            $this->container->registerPlugin($this->getSlug(), $this);
            $this->boot();
        }
    }

    /**
     *
     */
    abstract public function boot();
}
