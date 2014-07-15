<?php

namespace AHWEBDEV\FacebookAWD\Admin;

use AHWEBDEV\Wordpress\Admin\Admin as BaseAdmin;

/**
 * Description of Admin
 *
 * @author alexhermann
 */
class Admin extends BaseAdmin
{

    /**
     * Init the class
     */
    public function init()
    {
        $installController = $this->container->get('backend.install_controller');
        if (!$installController->isReady() || filter_input(INPUT_GET, 'master_settings', FILTER_SANITIZE_SPECIAL_CHARS)) {
            $installController->init();
        } else {
            //init plugins
            $this->container->get('backend.controller')->init();
            foreach ($this->container->getPlugins() as $data) {
                $data["instance"]->initControllers();
            }
            //the instance is ready to be stored into memory for next load
            //the container has pugins and services and controllers already set.
            $this->container->store();
        }
        add_action('admin_init', array($this, 'adminInit'));
    }

    /**
     * Register hook to print assets
     * @param string $pageHook
     */
    public function enqueueAssetsHook($pageHook)
    {
        add_action('admin_print_styles-' . $pageHook, array($this, 'enqueueStyles'));
        add_action('admin_print_scripts-' . $pageHook, array($this, 'enqueueScripts'));
        add_action('admin_print_styles-widgets.php', array($this, 'enqueueScripts'));
        add_action('admin_print_styles-widgets.php', array($this, 'enqueueStyles'));
    }

    public function initScreen()
    {
        add_screen_option('layout_columns', array('max' => 2, 'default' => 1));
    }

    /**
     * Init the admin
     */
    public function adminInit()
    {
        $pageHook = $this->getAdminMenuHook($this->container->getSlug());

        $this->container->getRoot()->registerAssets();
        $this->enqueueAssetsHook($pageHook);

        //plugins init hook
        foreach ($this->container->getPlugins() as $plugin) {
            $pluginObj = $plugin['instance'];
            $pageHook = $this->getAdminMenuHook($pluginObj->getSlug());
            if ($pageHook) {
                //enqueue generals assets on plugins
                $this->enqueueAssetsHook($pageHook);
            }
        }

        foreach ($this->getAdminMenuHooks() as $hook) {
            add_action('load-' . $hook, array($this, 'initScreen'));
        }

        //init the listener in admin only
        $requestListener = $this->container->get('listener.request_listener');
        $requestListener->adminInit();

        /*
          add_action('admin_print_styles-post-new.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-post.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-link-add.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-link.php', array($this, 'enqueueStyles'));
         */
    }

    /**
     * Enqueue the css styles
     */
    public function enqueueStyles()
    {
        wp_enqueue_style($this->container->getSlug() . 'bootstrap');
        wp_enqueue_style($this->container->getSlug() . 'animate');
        wp_enqueue_style($this->container->getSlug() . 'google-code-prettify');
        wp_enqueue_style('thickbox');
    }

    /**
     * Enqueue the javascripts scripts
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');

        wp_enqueue_script('common');
        wp_enqueue_script('wp-list');
        wp_enqueue_script('postbox');

        //TOdo Minify All files using grunt ?
        wp_enqueue_script($this->container->getSlug() . 'socket-io');
        wp_enqueue_script($this->container->getSlug() . 'socket');
        wp_enqueue_script($this->container->getSlug() . 'google-code-prettify');
        wp_enqueue_script($this->container->getSlug() . 'bootstrap');
        wp_enqueue_script($this->container->getSlug() . 'jquery-validate');
        //wp_enqueue_script('facebook-awd-bootstrap-tab-js');
        //wp_enqueue_script('facebook-awd-bootstrap-transition-js');
        //
        wp_enqueue_script($this->container->getSlug() . 'admin');
        wp_enqueue_script($this->container->getSlug() . 'admin-init');
        wp_enqueue_script('jquery-form');
        //wp_enqueue_script('facebook-awd-global-js');
    }

}
