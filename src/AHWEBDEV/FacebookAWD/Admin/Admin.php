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
            do_action('facebookawd_register_plugins', $this->container);
        }
        add_action('admin_init', array($this, 'adminInit'));
    }

    /**
     * Register hook to print assets
     * @param string $pageHook
     */
    public function regiterAssetsHook($pageHook)
    {
        add_action('admin_print_styles-' . $pageHook, array($this, 'enqueueStyles'));
        add_action('admin_print_scripts-' . $pageHook, array($this, 'enqueueScripts'));
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

        $this->registerAssets();
        $this->regiterAssetsHook($pageHook);

        //plugins init hook
        foreach ($this->container->getPlugins() as $plugin) {
            $pluginObj = $plugin['instance'];
            $pageHook = $this->getAdminMenuHook($pluginObj->getSlug());
            if ($pageHook) {
                $this->regiterAssetsHook($pageHook);
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
          add_action('admin_print_styles-widgets.php', array($this, 'enqueueStyles'));
         */
    }

    /**
     * Enqueue the css styles
     */
    public function enqueueStyles()
    {
        wp_enqueue_style($this->container->getSlug() . '-bootstrap-css');
        wp_enqueue_style($this->container->getSlug() . '-animate-css');
        wp_enqueue_style($this->container->getSlug() . '-google-code-prettify-css');
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

        wp_enqueue_script($this->container->getSlug() . '-google-code-prettify-js');
        wp_enqueue_script($this->container->getSlug() . '-bootstrap-js');
        wp_enqueue_script($this->container->getSlug() . '-jquery-validate-js');
        //wp_enqueue_script('facebook-awd-bootstrap-tab-js');
        //wp_enqueue_script('facebook-awd-bootstrap-transition-js');
        //
        //wp_enqueue_script('facebook-awd-admin-js');
        //wp_enqueue_script('facebook-awd-global-js');
    }

}
