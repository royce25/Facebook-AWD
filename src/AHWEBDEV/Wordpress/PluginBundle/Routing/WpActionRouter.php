<?php

namespace AHWEBDEV\Wordpress\PluginBundle\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * WpActionRouteLoader
 * 
 * This class is a Helper to generate sub request from a wordpress action
 * do_action('test') will be forwarded to a route named 'test'
 * The add_action
 * 
 * @todo Implement the router interface to be able to generate wordpress action also.
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Bundle
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class WpActionRouter
{

    /**
     * The http kernel
     * 
     * @var HttpKernelInterface 
     */
    protected $httpKernel;

    /**
     * The current request
     * 
     * @var Request 
     */
    protected $currentRequest;

    /**
     * Constructor
     * 
     * @param HttpKernelInterface $httpKernel
     * @param RequestStack $requestStack
     */
    public function __construct(HttpKernelInterface $httpKernel, RequestStack $requestStack)
    {
        $this->httpKernel = $httpKernel;
        $this->currentRequest = $requestStack->getCurrentRequest();
        if (!$this->currentRequest) {
            $this->currentRequest = Request::createFromGlobals();
        }
    }

    /**
     * Create the sub request
     * 
     * This method will clone the current request with a new path
     * 
     * @param Request $request
     * @param string  $path
     * @return Request
     */
    public static function cloneRequest(Request $request, $path)
    {
        $method = $request->getMethod();
        $parameters = $request->request->all();
        $cookies = $request->cookies->all();
        $files = $request->files->all();
        $servers = $request->server->all();
        $content = $request->getContent();

        return Request::create($path, $method, $parameters, $cookies, $files, $servers, $content);
    }

    /**
     * Handle the request
     * 
     * @param string $action
     * @return Response
     */
    public function handle($action)
    {
        $path = '/wpaction/' . $action;
        $request = self::cloneRequest($this->currentRequest, $path);
        $request->attributes->set('wpaction', true);
        $response = $this->httpKernel->handle($request, HttpKernelInterface::SUB_REQUEST);

        return $response;
    }

    /**
     * Get the default Action
     * 
     * Returns an callback array
     * This callback can be use as a bridge between 
     * wordpress actions and symfony routing
     * 
     * @return array
     */
    public function getDefaultAction()
    {
        return array($this, 'controllerAction');
    }

    /**
     * ControllerAction
     * 
     * @return Response
     */
    public function controllerAction()
    {
        //transfrom this action to controller action
        $response = $this->handle(current_action());
        $response->send();
        return $response;
    }

}
