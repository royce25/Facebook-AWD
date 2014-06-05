<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Controller\Controller;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BackendController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD
 */
class BackendController extends Controller
{

    /**
     * The admin menu hook references
     *
     * @var array
     */
    protected $adminMenuHooks = array();

    /**
     * Get the admin menu hook references
     *
     * @return array
     */
    public function getAdminMenuHooks()
    {
        return $this->adminMenuHooks;
    }

    /**
     * Set the admin menu hook references
     *
     * @param string
     */
    public function setAdminMenuHooks(array $adminMenuHooks)
    {
        $this->adminMenuHooks = $adminMenuHooks;

        return $this;
    }

    /**
     * Add an admin menu hook references
     *
     * @param  string $name
     * @param  callback $hook
     * @return \AHWEBDEV\FacebookAWD\Controller\BackendController
     */
    public function addAdminMenuHook($name, $hook)
    {
        $this->adminMenuHooks[$name] = $hook;

        return $this;
    }

    /**
     * Get an admin menu hook reference
     *
     * @return array
     */
    public function getAdminMenuHook($name)
    {
        if (isset($this->adminMenuHooks[$name])) {
            return $this->adminMenuHooks[$name];
        }
        return false;
    }

    /**
     * Remove an admin menu hook reference
     *
     * @param  string $name
     * @return \AHWEBDEV\FacebookAWD\Controller\BackendController
     */
    public function removeAdminMenuHook($name)
    {
        unset($this->adminMenuHooks[$name]);

        return $this;
    }

    /**
     * Init the admin
     * This method is called during plugins_loaded wordpress hook
     */
    public function init()
    {
        add_action('admin_menu', array($this, 'adminMenu'));
        add_action('admin_init', array($this, 'adminInit'));
        add_action("init", array($this, 'registerAssets'));
    }

    /**
     * Init the wordpress admin  menu
     */
    public function adminMenu()
    {
        //check install ok
        $installController = $this->container->get('backend.install_controller');

        if (!$installController->isReady() || isset($_REQUEST['master_settings'])) {
            $this->container->set('backend.home_controller', $installController);
        } else {
            //init plugins
            do_action('facebookawd_register_plugins', $this->container);
        }

        $menuTitle = $this->container->getTitle();
        $capability = 'manage_options';
        $menuSlug = $this->container->getSlug();
        $controller = $this->container->get('backend.home_controller');
        $pageHook = add_menu_page($menuTitle, $menuTitle, $capability, $menuSlug, array($controller, 'index'));
        $this->addAdminMenuHook($this->container->getSlug(), $pageHook);
    }

    public function regiterWPActionsHook($pageHook)
    {
        add_action('admin_print_styles-' . $pageHook, array($this, 'enqueueStyles'));
        add_action('admin_print_scripts-' . $pageHook, array($this, 'enqueueScripts'));
    }

    /**
     * Init the admin
     */
    public function adminInit()
    {
        $controller = $this->container->get('backend.home_controller');
        $pageHook = $this->getAdminMenuHook($this->container->getSlug());
        $this->regiterWPActionsHook($pageHook);
        add_action('load-' . $pageHook, array($controller, 'init'));
        add_screen_option('layout_columns', array('max' => 2, 'default' => 1));

        //plugin init
        foreach ($this->container->getPlugins() as $plugin) {
            $pluginObj = $plugin['instance'];
            $pageHook = $this->getAdminMenuHook($pluginObj->getSlug());
            if ($pageHook) {
                $this->regiterWPActionsHook($pageHook);
            }
        }

        /*
          add_action('admin_print_styles-post-new.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-post.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-link-add.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-link.php', array($this, 'enqueueStyles'));
          add_action('admin_print_styles-widgets.php', array($this, 'enqueueStyles')); */
    }

    /**
     * Register all assets inside the wordpress assets management system
     */
    public function registerAssets()
    {
        $assets = $this->container->getAssets();
        foreach ($assets as $type => $files) {
            foreach ($files as $fileName => $path) {
                $media = 'all';
                $deps = array();
                if ($type === 'script') {
                    $deps = array('jquery');
                    $media = true;
                }
                call_user_func_array('wp_register_' . $type, array($this->container->getSlug() . '-' . $fileName, plugins_url('facebook-awd/' . FacebookAWD::getResource($path)), $deps, null, $media));
            }
        }
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
