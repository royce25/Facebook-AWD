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

        //if ($event->isMasterRequest()) {
        //var_dump($request->query);
        //var_dump($request->request);
        //var_dump($request);

        if (!$request->attributes->has('wpaction')) {
            /* if($request->attributes->get('wpaction') == true){
              exit('wp_action');
              } */
            //call only if the root is not inside wordpress
            if ($request->attributes->has('wppath')) {
                //require_once($request->attributes->get('wppath') . '/wp-blog-header.php'); //
            }
        }
        //Parse only the _wpaction request
        /* if ($request->attributes->has('_wpaction')) {
          return;
          } */

        //$wpaction = $request->attributes->get('_wpaction');
        //$request->attributes->set('_route', array_replace($request->attributes->get('_route_params', array()), $attributes));
        //exit('dd');
        //}
    }

    public function fake()
    {
        
    }

}
