<?php

namespace AHWEBDEV\FacebookAWD\Provider\Wordpress\Controller;

use AHWEBDEV\FacebookAWD\Extension\Controller\BackendController as BaseBackendController;
use AHWEBDEV\FacebookAWD\FacebookAWD;

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
 * @package FacebookAWD\Extension\Wordpress
 */
class BackendController extends BaseBackendController
{
    /**
     * The position of the menu in list
     * @var string
     */

    const MENU_POSITION = 6;

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
        $assets = $this->facebookAWD->getAssets();
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
        $menuItems = $this->getMenuItems();
        $template = dirname($this->facebookAWD->getFile()) . '/Resources/views/admin/index.html.php';
        echo parent::render($template, array('menuItems' => $menuItems));
    }

}

?>
