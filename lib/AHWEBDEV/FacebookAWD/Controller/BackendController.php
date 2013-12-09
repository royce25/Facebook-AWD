<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Controller\BackendControllerInterface;
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
class BackendController extends Controller implements BackendControllerInterface
{
    /**
     * The position of the menu in list
     * @var string
     */

    const MENU_POSITION = 6;

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
     * @param string $name
     * @param callback $hook
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
        return $this->adminMenuHooks[$name];
    }

    /**
     * Remove an admin menu hook reference
     *
     * @param string $name
     * @return \AHWEBDEV\FacebookAWD\Controller\BackendController
     */
    public function removeAdminMenuHook($name)
    {
        unset($this->adminMenuHooks[$name]);
        return $this;
    }

    /**
     * Get the menu iems as array
     *
     * @return array
     */
    public function getBlockItems()
    {
        return array(
            'home' => array(
                'title' => "Home",
                'controller' => $this->container->get('backend.home_controller'),
                'action' => 'home'
            )
        );
    }

    /**
     * Init the admin
     */
    public function init()
    {
        add_action('admin_menu', array(&$this, 'adminMenu'));
        add_action('admin_init', array(&$this, 'adminInit'));
        add_action("init", array(&$this, 'registerAssets'));
    }

    /**
     * Init the wordpress admin  menu
     */
    public function adminMenu()
    {
        $parentSlug = 'options-general.php';
        $menuTitle = $pageTitle = FacebookAWD::PLUGIN_ADMIN_NAME;
        $capability = 'manage_options';
        $menuSlug = FacebookAWD::PLUGIN_SLUG;
        $callback = array($this, 'content');

        //check install ok
        $installController = $this->container->get('backend.install_controller');
        if (!$installController->isReady() || isset($_REQUEST['settings'])) {
            $callback = array($installController, 'install');
        }

        $hook = add_submenu_page($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $callback);
        $this->addAdminMenuHook($menuSlug, $hook);
    }

    /**
     * Init the admin
     */
    public function adminInit()
    {
        $hook = $this->getAdminMenuHook(FacebookAWD::PLUGIN_SLUG);
        add_action('admin_print_styles-' . $hook, array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-post-new.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-post.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-link-add.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-link.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-widgets.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_scripts-' . $hook, array(&$this, 'enqueueScripts'));
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
                call_user_func_array('wp_register_' . $type, array('facebook-awd-' . $fileName, plugins_url('facebook-awd/' . FacebookAWD::getResource($path)), $deps, null, $media));
            }
        }
    }

    /**
     * Enqueue the css styles
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('facebook-awd-bootstrap-css');
        wp_enqueue_style('facebook-awd-google-code-prettify-css');
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

        //wp_enqueue_script('facebook-awd-bootstrap-js');
        wp_enqueue_script('facebook-awd-jquery-validate-js');
        wp_enqueue_script('facebook-awd-bootstrap-tab-js');
        wp_enqueue_script('facebook-awd-bootstrap-transition-js');
        wp_enqueue_script('facebook-awd-google-code-prettify-js');
        wp_enqueue_script('facebook-awd-admin-js');
        wp_enqueue_script('facebook-awd-global-js');
    }

    /**
     * Base Admin content
     */
    public function content()
    {
        $template = dirname($this->container->getFile()) . '/Resources/views/admin/index.html.php';
        echo $this->render($template, array('blockView'=> $this->container->get('backend.home_controller')->home()));
    }

}

?>
