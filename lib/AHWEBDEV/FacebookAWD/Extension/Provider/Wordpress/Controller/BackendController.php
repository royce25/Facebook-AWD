<?php

namespace AHWEBDEV\FacebookAWD\Extension\Provider\Wordpress\Controller;

use AHWEBDEV\FacebookAWD\Extension\Model\BackendController as BaseBackendController;
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
 * @packae FacebookAWD\Extension\Wordpress
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
    }

    /**
     * Init the layout for internal pages
     */
    public function layout()
    {
        add_screen_option('layout_columns', array('max' => 2, 'default' => 2));
    }

    /**
     * Init the wordpress admin  menu
     */
    public function adminMenu()
    {
        $facebookAWDAdminPicto = plugins_url(FacebookAWD::getAsset('img/facebook-mini.png'));
        $facebookAWDSettingsPicto = plugins_url(FacebookAWD::getAsset('img/settings.png'));
        $facebookAWDPluginsPicto = plugins_url(FacebookAWD::getAsset('img/plugins.png'));
        $facebookAWDOpenGraphPicto = plugins_url(FacebookAWD::getAsset('img/ogp-logo.png'));

        $settingsMenuHook = add_menu_page(FacebookAWD::PLUGIN_ADMIN_NAME, __(FacebookAWD::PLUGIN_NAME, FacebookAWD::PTD), 'manage_options', FacebookAWD::PLUGIN_SLUG, array($this, 'content'), $facebookAWDAdminPicto, self::MENU_POSITION);
        add_submenu_page(FacebookAWD::PLUGIN_SLUG, __('Settings', FacebookAWD::PTD), '<img src="' . $facebookAWDSettingsPicto . '" /> ' . __('Settings', FacebookAWD::PTD), 'manage_options', FacebookAWD::PLUGIN_SLUG);
        $this->setSettingsMenuHook($settingsMenuHook);

        $pluginsMenuHook = add_submenu_page(FacebookAWD::PLUGIN_SLUG, __('Plugins', FacebookAWD::PTD), '<img src="' . $facebookAWDPluginsPicto . '" /> ' . __('Plugins', FacebookAWD::PTD), 'manage_options', FacebookAWD::PLUGIN_SLUG . '_plugins', array($this, 'content'));
        $this->setPluginsMenuHook($pluginsMenuHook);

        $opengraphMenuHook = add_submenu_page(FacebookAWD::PLUGIN_SLUG, __('Open Graph', FacebookAWD::PTD), '<img src="' . $facebookAWDOpenGraphPicto . '" /> ' . __('Open Graph', FacebookAWD::PTD), 'manage_options', FacebookAWD::PLUGIN_SLUG . '_opengraph', array($this, 'content'));
        $this->setOpengraphMenuHook($opengraphMenuHook);
    }

    /**
     * Init the admin
     */
    public function adminInit()
    {
        add_action("load-" . $this->getSettingsMenuHook(), array(&$this, 'layout'));
        add_action("load-" . $this->getPluginsMenuHook(), array(&$this, 'layout'));
        add_action("load-" . $this->getOpengraphMenuHook(), array(&$this, 'layout'));

        add_action('admin_print_styles-' . $this->getSettingsMenuHook(), array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-' . $this->getPluginsMenuHook(), array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-' . $this->getOpengraphMenuHook(), array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-post-new.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-post.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-link-add.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-link.php', array(&$this, 'enqueueStyles'));
        add_action('admin_print_styles-widgets.php', array(&$this, 'enqueueStyles'));

        add_action('admin_print_scripts-' . $this->getSettingsMenuHook(), array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-' . $this->getPluginsMenuHook(), array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-' . $this->getOpengraphMenuHook(), array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-post-new.php', array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-post.php', array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-link-add.php', array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-link.php', array(&$this, 'enqueueScripts'));
        add_action('admin_print_scripts-widgets.php', array(&$this, 'enqueueScripts'));

        //register the meta boxes
        //Settings page
        $facebookAWDSettingsPicto = plugins_url(FacebookAWD::getAsset('img/settings.png'));
        add_meta_box(FacebookAWD::PLUGIN_SLUG . "_settings", __('Settings', FacebookAWD::PTD) . ' <img style="vertical-align:middle;" src="' . $facebookAWDSettingsPicto . '" />', array(&$this, 'settingsContent'), $this->getSettingsMenuHook(), 'normal', 'core');

        //add_meta_box(FacebookAWD::PLUGIN_SLUG . "_facebook", __('My Facebook', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'facebook-mini.png" alt="facebook logo"/>', array(&$this, 'facebookUserContent'), $this->getAdminMenuHook(), 'side', 'core');
        //add_meta_box(FacebookAWD::PLUGIN_SLUG . "_app_infos", __('Application Infos', self::PTD) . ' ' . $icon, array(&$this, 'appInfosContent'), $this->getAdminMenuHook(), 'side', 'core');
        //add_meta_box(FacebookAWD::PLUGIN_SLUG . "_info_metabox", __('About the developper', self::PTD), array(&$this, 'generalContent'), $this->getAdminMenuHook(), 'side', 'core');
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

        wp_enqueue_script('facebook-awd-bootstrap-js');
        wp_enqueue_script('facebook-awd-google-code-prettify-js');
        wp_enqueue_script('facebook-awd-admin-js');
        wp_enqueue_script('facebook-awd-global-js');
    }

    /**
     * Base Admin content
     */
    public function content()
    {
        //global $screen_layout_columns;
        $page = $_GET['page'];
        //$page_hook = $this->getSettingsMenuHook();
        //$screen = get_current_screen();
        $templateManager = $this->facebookAWD->getTemplateManager();
        global $submenu;
        $menuItems = array();
        if (isset($submenu[FacebookAWD::PLUGIN_SLUG])) {
            foreach ($submenu[FacebookAWD::PLUGIN_SLUG] as $page) {
                $menuItems[] = array(
                    'class' => $page == $page[2] ? 'active' : '',
                    'url' => admin_url('admin.php?page=' . $page[2]),
                    'title' => $page[3],
                    'value' => $page[0]
                );
            }
        }
        //render the admin view
        $template = dirname($this->facebookAWD->getFile()) . '/Resources/views/admin/index.html.php';
        $templateManager->render($template, array(
            'menuItems' => $menuItems
        ));
    }

    public function settingsContent()
    {
        echo 111;
    }
}

?>
