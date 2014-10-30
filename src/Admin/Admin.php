<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 * @author Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */

namespace AHWEBDEV\FacebookAWD\Admin;

use AHWEBDEV\Wordpress\Admin\Admin as BaseAdmin;

/**
 * This is the base admin class
 *
 * This file add required hooks in wordpress admin using controllers and models
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class Admin extends BaseAdmin
{

    /**
     * Init the class
     */
    public function init()
    {
        $installController = $this->container->get('controller.install');
        if (!$installController->isReady() || filter_input(INPUT_GET, 'master_settings')) {
            $installController->init();
        } else {
            //init plugins
            $this->container->get('controller.front')->init();
            $this->container->get('controller.backend')->init();
            foreach ($this->container->getPlugins() as $plugin) {
                //@todo put this in interface
                $plugin->initControllers();
            }
        }
        add_action('admin_init', array($this, 'adminInit'));
        return $this;
    }

    /**
     * Register hook to print assets
     * 
     * @param string $pageHook
     */
    public function enqueueAssetsHook($pageHook)
    {
        add_action('admin_print_styles-' . $pageHook, array($this, 'enqueueStyles'));
        add_action('admin_print_scripts-' . $pageHook, array($this, 'enqueueScripts'));
        add_action('admin_print_styles-widgets.php', array($this, 'enqueueScripts'));
        add_action('admin_print_styles-widgets.php', array($this, 'enqueueStyles'));
    }

    /**
     * init the admin screen layout
     */
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

        foreach ($this->getAdminMenuHooks() as $hook) {
            add_action('load-' . $hook, array($this, 'initScreen'));
            $this->enqueueAssetsHook($hook);
        }
    }

    /**
     * Enqueue the css styles
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('thickbox');

        wp_enqueue_style($this->container->getSlug() . 'bootstrap');
        wp_enqueue_style($this->container->getSlug() . 'animate');
        wp_enqueue_style($this->container->getSlug() . 'prettify');
    }

    /**
     * Enqueue the javascripts scripts
     */
    public function enqueueScripts()
    {
        //native wp scripts
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('common');
        wp_enqueue_script('wp-list');
        wp_enqueue_script('postbox');
        wp_enqueue_script('jquery-form');
        wp_enqueue_script('jquery');

        //add local scripts
        wp_enqueue_script($this->container->getSlug() . 'socket-io');
        wp_enqueue_script($this->container->getSlug() . 'socket');
        wp_enqueue_script($this->container->getSlug() . 'google-code-prettify');
        wp_enqueue_script($this->container->getSlug() . 'bootstrap');
        wp_enqueue_script($this->container->getSlug() . 'jquery-validate');
        wp_enqueue_script($this->container->getSlug() . 'admin');
        wp_enqueue_script($this->container->getSlug() . 'prettify');
        wp_enqueue_script($this->container->getSlug() . 'admin-init');

        //required to have the init and facebook data in the admin
        $this->container->get('controller.front')->enqueueScripts();
    }

}
