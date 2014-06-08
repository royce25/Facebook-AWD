<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeBox;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Plugin\Plugin;

/**
 * Facebook AWD LikeButton
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class LikeBoxPlugin extends Plugin
{

    const PLUGIN_SLUG = 'facebookawd_likebox';

    /**
     *
     */
    public function __construct()
    {
        add_action('facebookawd_register_plugins', array($this, 'init'));
    }

    public function getSlug()
    {
        return $this::PLUGIN_SLUG;
    }

    public function boot()
    {
        add_action('admin_menu', array($this, 'adminMenu'), 11);
    }

    public function adminMenu()
    {
        $pageHook = add_submenu_page($this->container->getSlug(), 'likebox', __('Like box', $this->container->getPtd()), 'manage_options', $this::PLUGIN_SLUG, array($this, 'content'));
    }

    public function content()
    {
        //echo 111;
    }
}
