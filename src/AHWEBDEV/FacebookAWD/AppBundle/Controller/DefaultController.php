<?php

namespace AHWEBDEV\FacebookAWD\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * Test a wp action 
     * 
     * @return Response
     */
    public function testHookRequestAction(Request $request)
    {
        //var_dump($request->attributes);
        //$response = new Response();
        return $this->render('AHWEBDEVFacebookAWDAppBundle:Default:index.html.twig');
    }

    /**
     * Test a wp action 
     * 
     * @return Response
     */
    public function testHookRequest2Action(Request $request)
    {
        //var_dump($request->attributes);
        $response = new Response('Ok sub request 6');
        return $response;
    }

}
