<?php

namespace AHWEBDEV\Wordpress\PluginBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * RequestListener
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Bundle
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class RequestListener
{

    /**
     * 
     * @param GetResponseEvent $event
     * @return type
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
    }

}
