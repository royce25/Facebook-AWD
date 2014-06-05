<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeButton;

use AHWEBDEV\FacebookAWD\Plugin\LikeButton\Controller\SettingsController;
use AHWEBDEV\Framework\Plugin\Plugin;

/**
 * Facebook AWD LikeButton
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class LikeButtonPlugin extends Plugin
{

    public function __construct()
    {
        $this->slug = 'facebookawd_likebutton';
        $this->title = 'Facebook AWD Like Button';
        $this->ptd = 'facebookawd_likebutton';
        parent::__construct();
        add_action('facebookawd_register_plugins', array($this, 'init'));
    }

    public function boot()
    {
        //required to access service when controller is extend
        //$this->services = $this->container->getServices();
        
        $controller = new SettingsController($this);
        $this->set('backend.controller', $controller);
        $controller->init();
    }

}
