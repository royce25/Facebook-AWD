<?php

namespace AHWEBDEV\Wordpress\PluginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WpController extends Controller
{

    /**
     * General request is passed to this action
     * Response should stay empty
     * 
     * @return Response
     */
    public function bootAction()
    {
        return new Response('Default boot ff');
    }

    public function blankAction()
    {
        //$this->get('ahwebdev_wordpress_plugin.admin.manager')->boot();
        return new Response('ok blank');
    }

}
