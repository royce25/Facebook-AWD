<?php

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Api\AWD_facebook_api;
use AHWEBDEV\FacebookAWD\TemplateManager\AWD_facebook_form;
use AHWEBDEV\FacebookAWD\TemplateManager\AWD_facebook_widget;
use AHWEBDEV\FacebookAWD\ExtensionBridge\ExtensionBridgeInterface;
use AWD_facebook_plugin_interface;
use Exception;
use FacebookApiException;
use OpenGraphProtocol;
use OpenGraphProtocolImage;
use OpenGraphProtocolVideo;

/**
 * Facebook AWD All in One
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class FacebookAWD_1
{
    /**
     * The name of the plugin
     */
    const PLUGIN_NAME = 'Facebook AWD';

    /**
     * The slug of the plugin
     */
    const PLUGIN_SLUG = 'awd_fcbk';

    /**
     * The prefix used in options
     */
    const OPTION_PREFIX = 'awd_fcbk_option_';

    /**
     * The title of the admin interface
     */
    const PLUGIN_ADMIN_NAME = 'Facebook Admin';

    /**
     * The plugin text domain
     */
    const PTD = 'AWD_facebook';

    /**
     * The options of the plugins
     * @var array
     */
    protected $options = array();

    /**
     * The options manager
     * @var AWD_facebook_options
     */
    protected $optionsManager;

    /**
     * The templates manager
     * @var AWD_facebook_template
     */
    protected $templatesManager;

    /**
     * The plugins of Facebook AWD
     * @var array
     */
    protected $plugins = array();

    /**
     * The dependencies of the plugins
     * @var array
     */
    protected $dependencies = array();

    /**
     * The current facebook user data
     * @var array
     */
    protected $me = array();

    /**
     * The facebook php SDK instance
     * @var AWD_facebook_api
     */
    protected $fcbk = null;

    /**
     * The ID of the current facebook user.
     * @var integer
     */
    protected $uid = null;

    /**
     * The internal url to login
     * @var string
     */
    protected $authenthicationEntryPointUrl;

    /**
     * The internal url to logout
     * @var string
     */
    protected $logoutUrl;

    /**
     * The internal url to unsyc account
     * @var string
     */
    protected $unsyncUrl;

    /**
     * The url of the plugin
     * @var string
     */
    public $pluginUrl;

    /**
     * The facebook authentication Entry Point Url
     * @var string
     */
    protected $oauthUrl;

    /**
     * The url of the plugin images directory
     * @var string
     */
    public $pluginImagesUrl;

    protected $javascriptsAssets = array();
    protected $stylesheetAssets = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        /*if(!$pluginBridge instanceof ExtensionBridgeInterface)
            throw new \InvalidArgumentException('The plugin bridge must implements the ExtensionBridgeInterface');

        $this->pluginBridge = $pluginBridge;
        $this->pluginBridge->init($this);*/

        /*//init the plugin and action
        add_action('after_setup_theme', array(&$this, 'initial'));
        //like box widget register
        add_action('widgets_init', array(&$this, 'register_AWD_facebook_widgets'));
        $ps = get_option('permalink_structure');
        //Base vars
        $this->authenthicationEntryPointUrl = $ps != '' ? home_url('facebook-awd/login') : home_url('?facebook_awd[action]=login');
        $this->logoutUrl = $ps != '' ? home_url('facebook-awd/logout') : home_url('?facebook_awd[action]=logout');
        $this->unsyncUrl = $ps != '' ? home_url('facebook-awd/unsync') : home_url('?facebook_awd[action]=unsync');

        //$this->_channel_url = $ps != '' ? home_url('facebook-awd/channel.html') : home_url('?facebook_awd[action]=channel.html');
        //$this->_deauthorize_url = $ps != '' ? home_url('facebook-awd/deauthorize') : home_url('?facebook_awd[action]=deauthorize');
        //$this->_realtime_api_url = $ps != '' ? home_url('facebook-awd/realtime-update-api') : home_url('?facebook_awd[action]=realtime-update-api');
    */}

    /**
     * Plugin Init
     */
    public function initial()
    {
        include_once(dirname(__FILE__) . '/inc/init.php');
    }

    /**
     * Get the plugin path
     * required for Facebook AWD plugins
     * @return string
     */
    public function getPluginsModelPath()
    {
        return realpath(dirname(__FILE__)) . '/inc/classes/plugins/class.AWD_facebook_plugin_abstract.php';
    }

    /**
     * Add support for opengraph image
     */
    public function addThemeSupport()
    {
        //add fetured image menu to get FB image in open Graph set image 50x50
        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
            add_image_size('AWD_facebook_ogimage', 200, 200, true);
        }
        //add featured image + post excerpt in post type too.
        if (function_exists('add_post_type_support')) {
            $post_types = get_post_types();
            foreach ($post_types as $type) {
                add_post_type_support($type, array(
                    'thumbnails',
                    'excerpt'));
            }
        }
    }

    /**
     * Return the current user object
     * @return WP_User
     */
    public function getCurrentUser()
    {
        return wp_get_current_user();
    }

    /**
     * Getter Version
     * @param  array  $pluginFolderVar
     * @return string
     */
    public function getVersion($pluginFolderVar = array())
    {
        if (count($pluginFolderVar) == 0) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            $pluginFolder = get_plugins();
        }

        return $pluginFolder['facebook-awd/AWD_facebook.php']['Version'];
    }

    //****************************************************************************************
    //	Checking
    //****************************************************************************************

    /**
     * Display Errors if configuration is missing
     */
    public function missingConfig()
    {
        if ($this->options['app_id'] == '') {
            $this->templateManager->addError(new \WP_Error('AWD_facebook_not_ready', __('Facebook AWD is almost ready... Go to settings and set your FB Application ID.', self::PTD)));
        }
        if ($this->options['app_secret_key'] == '') {
            $this->templateManager->addError(new \WP_Error('AWD_facebook_not_ready', __('Facebook AWD is almost ready... Go to settings and set your FB Secret Key.', self::PTD)));
        }
    }

    //****************************************************************************************
    //	ADMIN
    //****************************************************************************************

    /**
     * Save customs fields during post edition
     * This will be called on sheduled post too
     * WARNING Sheduled posts published event is only fired when someone hit the website.
     * The publish to facebook hook is anonimous as we store the pages's access token.
     *
     * @param int $postId
     */
    public function handlePostUpdate($postId)
    {
        if (!wp_is_post_revision($postId)) {

            $post = get_post($postId);
            $options = get_post_meta($postId, self::PLUGIN_SLUG, true);

            foreach ($_POST as $__post => $val) {
                if (preg_match('@' . self::OPTION_PREFIX . '@', $__post)) {
                    $name = str_ireplace(self::OPTION_PREFIX, '', $__post);
                    $options[$name] = $val;
                }
            }

            update_post_meta($post->ID, self::PLUGIN_SLUG, $options);

            $this->publishPostToFacebookHook($post);
        }
    }

    /**
     * Add footer text ads Facebook AWD version
     *
     * @param  string $footer_text
     * @return string
     */
    public function adminFooterText($footer_text)
    {
        return $footer_text . "  " . __('| With:', self::PTD) . " <a href='http://facebook-awd.ahwebdev.fr/'>" . self::PLUGIN_NAME . " v" . $this->getVersion() . "</a>";
    }

    /**
     * Admin plugin menu init
     */
    public function adminMenu()
    {
        //admin hook
        $this->setAdminMenuHook(add_menu_page(self::PLUGIN_ADMIN_NAME, __(self::PLUGIN_NAME, self::PTD), 'manage_facebook_awd_publish_to_pages', self::PLUGIN_SLUG, array($this, 'adminContent'), $this->pluginImagesUrl . 'facebook-mini.png', self::MENU_POSITION));
        add_submenu_page(self::PLUGIN_SLUG, __('Settings', self::PTD), '<img src="' . $this->pluginImagesUrl . 'settings.png" /> ' . __('Settings', self::PTD), 'manage_facebook_awd_publish_to_pages', self::PLUGIN_SLUG);

        $this->setPluginsMenuHook(add_submenu_page(self::PLUGIN_SLUG, __('Plugins', self::PTD), '<img src="' . $this->pluginImagesUrl . 'plugins.png" /> ' . __('Plugins', self::PTD), 'manage_facebook_awd_plugins', self::PLUGIN_SLUG . '_plugins', array($this, 'adminContent')));

        add_action("load-" . $this->getAdminMenuHook(), array(&$this, 'adminInitialisation'));
        add_action("load-" . $this->getPluginsMenuHook(), array(&$this, 'adminInitialisation'));

        add_action('admin_print_styles-' . $this->getAdminMenuHook(), array(&$this, 'adminEnqueueCss'));
        add_action('admin_print_styles-' . $this->getPluginsMenuHook(), array(&$this, 'adminEnqueueCss'));
        add_action('admin_print_styles-post-new.php', array(&$this, 'adminEnqueueCss'));
        add_action('admin_print_styles-post.php', array(&$this, 'adminEnqueueCss'));
        add_action('admin_print_styles-link-add.php', array(&$this, 'adminEnqueueCss'));
        add_action('admin_print_styles-link.php', array(&$this, 'adminEnqueueCss'));
        add_action('admin_print_styles-widgets.php', array(&$this, 'adminEnqueueCss'));

        add_action('admin_print_scripts-' . $this->getAdminMenuHook(), array(&$this, 'adminEnqueueJs'));
        add_action('admin_print_scripts-' . $this->getPluginsMenuHook(), array(&$this, 'adminEnqueueJs'));
        add_action('admin_print_scripts-post-new.php', array(&$this, 'adminEnqueueJs'));
        add_action('admin_print_scripts-post.php', array(&$this, 'adminEnqueueJs'));
        add_action('admin_print_scripts-link-add.php', array(&$this, 'adminEnqueueJs'));
        add_action('admin_print_scripts-link.php', array(&$this, 'adminEnqueueJs'));
        add_action('admin_print_scripts-widgets.php', array(&$this, 'adminEnqueueJs'));

        if ($this->options['open_graph_enable'] == 1) {
            $this->setOpengraphMenuHook(add_submenu_page(self::PLUGIN_SLUG, __('Open Graph', self::PTD), '<img src="' . $this->pluginImagesUrl . 'ogp-logo.png" /> ' . __('Open Graph', self::PTD), 'manage_facebook_awd_opengraph', self::PLUGIN_SLUG . '_open_graph', array($this, 'adminContent')));
            add_action("load-" . $this->getOpengraphMenuHook(), array(&$this, 'adminInitialisation'));
            add_action('admin_print_styles-' . $this->getOpengraphMenuHook(), array(&$this, 'adminEnqueueCss'));
            add_action('admin_print_scripts-' . $this->getOpengraphMenuHook(), array(&$this, 'adminEnqueueJs'));
        }

        //enqueue here the library facebook connect
        $this->loadJs();
        //Add meta box
        $this->addMetaBoxes();
    }

    /**
     * Admin initialisation
     */
    public function adminInitialisation()
    {
        //add 2 column screen
        add_screen_option('layout_columns', array('max' => 2, 'default' => 2));
    }

    /**
     * Add admin meta boxes
     */
    public function addMetaBoxes()
    {
        $icon = isset($this->options['app_infos']['icon_url']) ? '<img style="vertical-align:middle;" src="' . $this->options['app_infos']['icon_url'] . '" alt=""/>' : '';

        //Settings page
        if ($this->getAdminMenuHook() != '') {
            add_meta_box(self::PLUGIN_SLUG . "_settings_metabox", __('Settings', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'settings.png" />', array(&$this, 'settingsContent'), $this->getAdminMenuHook(), 'normal', 'core');
            add_meta_box(self::PLUGIN_SLUG . "_meta_metabox", __('My Facebook', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'facebook-mini.png" alt="facebook logo"/>', array(&$this, 'facebookUserContent'), $this->getAdminMenuHook(), 'side', 'core');
            add_meta_box(self::PLUGIN_SLUG . "_app_infos_metabox", __('Application Infos', self::PTD) . ' ' . $icon, array(&$this, 'appInfosContent'), $this->getAdminMenuHook(), 'side', 'core');
            add_meta_box(self::PLUGIN_SLUG . "_info_metabox", __('Informations', self::PTD), array(&$this, 'generalContent'), $this->getAdminMenuHook(), 'side', 'core');
            if (current_user_can('manage_facebook_awd_settings')) {
                add_meta_box(self::PLUGIN_SLUG . "_activity_metabox", __('Activity on your site', self::PTD), array(&$this, 'activityContent'), $this->getAdminMenuHook(), 'side', 'core');
            }
        }
        //Plugins page
        if ($this->getPluginsMenuHook() != '') {
            add_meta_box(self::PLUGIN_SLUG . "_plugins_metabox", __('Plugins Settings', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'plugins.png" />', array(&$this, 'pluginsContent'), $this->getPluginsMenuHook(), 'normal', 'core');
            add_meta_box(self::PLUGIN_SLUG . "_meta_metabox", __('My Facebook', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'facebook-mini.png" alt="facebook logo"/>', array(&$this, 'facebookUserContent'), $this->getPluginsMenuHook(), 'side', 'core');
            add_meta_box(self::PLUGIN_SLUG . "_app_infos_metabox", __('Application Infos', self::PTD) . ' ' . $icon, array(&$this, 'appInfosContent'), $this->getPluginsMenuHook(), 'side', 'core');
            add_meta_box(self::PLUGIN_SLUG . "_info_metabox", __('Informations', self::PTD), array(&$this, 'generalContent'), $this->getPluginsMenuHook(), 'side', 'core');
            if (current_user_can('manage_facebook_awd_settings')) {
                add_meta_box(self::PLUGIN_SLUG . "_activity_metabox", __('Activity on your site', self::PTD), array(&$this, 'activityContent'), $this->getPluginsMenuHook(), 'side', 'core');
            }
        }
        $post_types = get_post_types();
        foreach ($post_types as $type) {
            //Like button manager on post page type
            add_meta_box(self::PLUGIN_SLUG . "_awd_mini_form_metabox", __('Facebook AWD Manager', self::PTD) . ' <img style="vertical-align:middle;" style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'facebook-mini.png" alt="facebook logo"/>', array(&$this, 'postManagerContent'), $type, 'side', 'core');
        }

        if ($this->getOpengraphMenuHook() != '') {
            if ($this->options['open_graph_enable'] == 1) {
                add_meta_box(self::PLUGIN_SLUG . "_open_graph_metabox", __('Open Graph', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'ogp-logo.png" />', array(&$this, 'openGraphContent'), $this->getOpengraphMenuHook(), 'normal', 'core');
                add_meta_box(self::PLUGIN_SLUG . "_meta_metabox", __('My Facebook', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'facebook-mini.png" alt="facebook logo"/>', array(&$this, 'facebookUserContent'), $this->getOpengraphMenuHook(), 'side', 'core');
                add_meta_box(self::PLUGIN_SLUG . "_app_infos_metabox", __('Application Infos', self::PTD) . ' ' . $icon, array(&$this, 'appInfosContent'), $this->getOpengraphMenuHook(), 'side', 'core');
                add_meta_box(self::PLUGIN_SLUG . "_info_metabox", __('Informations', self::PTD), array(&$this, 'generalContent'), $this->getOpengraphMenuHook(), 'side', 'core');
                if (current_user_can('manage_facebook_awd_settings')) {
                    add_meta_box(self::PLUGIN_SLUG . "_activity_metabox", __('Activity on your site', self::PTD), array(&$this, 'activityContent'), $this->getOpengraphMenuHook(), 'side', 'core');
                }
            }
        }

        //Call the menu init to get page hook for each menu
        do_action('AWD_facebook_admin_menu');

        //For each page hook declared in plugins add side meta box
        $plugins = $this->plugins;
        foreach ($plugins as $plugin) {
            if ($plugin->getAdminMenuHook() != null) {
                $page_hook = $plugin->getAdminMenuHook();
                add_meta_box(self::PLUGIN_SLUG . "_meta_metabox", __('My Facebook', self::PTD) . ' <img style="vertical-align:middle;" src="' . $this->pluginImagesUrl . 'facebook-mini.png" alt="facebook logo"/>', array(&$this, 'facebookUserContent'), $page_hook, 'side', 'core');
                add_meta_box(self::PLUGIN_SLUG . "_app_infos_metabox", __('Application Infos', self::PTD) . ' ' . $icon, array(&$this, 'appInfosContent'), $page_hook, 'side', 'core');
                add_meta_box(self::PLUGIN_SLUG . "_info_metabox", __('Informations', self::PTD), array(&$this, 'generalContent'), $page_hook, 'side', 'core');
                if (current_user_can('manage_facebook_awd_settings')) {
                    add_meta_box(self::PLUGIN_SLUG . "_activity_metabox", __('Activity on your site', self::PTD), array(&$this, 'activityContent'), $page_hook, 'side', 'core');
                }
            }
        }
    }

    /**
     * Admin css enqueue Stylesheet
     */
    public function adminEnqueueCss()
    {
        wp_enqueue_style(self::PLUGIN_SLUG . '-ui-bootstrap');
        wp_enqueue_style(self::PLUGIN_SLUG . '-google-code-prettify-css');
        wp_enqueue_style('thickbox');
    }

    /**
     * Admin js enqueue Javascript
     */
    public function adminEnqueueJs()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('common');
        wp_enqueue_script('wp-list');
        wp_enqueue_script('postbox');
        wp_enqueue_script(self::PLUGIN_SLUG . '-admin-js');
        wp_enqueue_script(self::PLUGIN_SLUG . '-bootstrap-js');
        wp_enqueue_script(self::PLUGIN_SLUG . '-google-code-prettify');
    }

    /**
     * Add required javascript vars to work with the plugin
     */
    public function loadJs()
    {
        $AWD_facebook_vars = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'homeUrl' => home_url(),
            'loginUrl' => $this->_login_url,
            'logoutUrl' => $this->_logout_url,
            'scope' => current_user_can("manage_options") ? $this->options["perms_admin"] : $this->options["perms"],
            'app_id' => $this->options['app_id'],
            'FBEventHandler' => array('callbacks' => array()));
        $AWD_facebook_vars = apply_filters('AWD_facebook_js_vars', $AWD_facebook_vars);
        wp_localize_script(self::PLUGIN_SLUG, self::PLUGIN_SLUG, $AWD_facebook_vars);
        wp_enqueue_script(self::PLUGIN_SLUG);
    }

    /**
     * Add javascript resources in front end
     */
    public function frontEnqueueJs()
    {
        wp_enqueue_style(self::PLUGIN_SLUG . '-ui-bootstrap');
        $this->loadJs();
    }

    /**
     * Admin general infos
     */
    public function generalContent()
    {
        if (current_user_can('manage_facebook_awd_settings')) {
            echo '<h2>' . __('Plugins installed', self::PTD) . '</h2>';
            if (is_array($this->plugins) && count($this->plugins)) {
                foreach ($this->plugins as $plugin) {
                    echo '<p><span class="label label-success">' . $plugin::PLUGIN_NAME . ' <small>v' . $plugin->getVersion() . '</small></span></p>';
                }
            } else {
                echo '<p><span class="label label-inverse">' . __('No plugin found', self::PTD) . '</span></p>';
            }
            echo '<p><a href="http://facebook-awd.ahwebdev.fr/plugins/" class="btn btn-important" target="blank">' . __('Find plugins', self::PTD) . '</a></p>';
        }

        echo '<h4>' . __('Follow me on Facebook', self::PTD) . '</h4>';
        echo do_shortcode('[AWD_facebook_likebox href="https://www.facebook.com/Ahwebdev" colorscheme="light" stream="0" height="260" show_faces="1" xfbml="0" width="257"]');
        echo '<h4>' . __('Follow me on Twitter', self::PTD) . '</h4>
            <a href="https://twitter.com/ah_webdev" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="true">Follow @ah_webdev</a>
            <script>!function (d,s,id) {var js,fjs=d.getElementsByTagName(s)[0];if (!d.getElementById(id)) {js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    }

    /**
     * Get app infos content
     */
    public function getAppInfosContent()
    {
        echo $this->getAppInfos();
        //call the app_content function
        echo $this->appInfosContent();
        exit();
    }

    /**
     * Get App infos form api and store them in options
     */
    public function getAppInfos()
    {
        if (is_object($this->fcbk)) {
            try {
                $appInfos = $this->fcbk->api('/' . $this->options['app_id']);
                $this->options['app_infos'] = $this->optionsManager->updateOption('app_infos', $appInfos, true);
            } catch (Exception $e) {
                $this->options['app_infos'] = $this->optionsManager->updateOption('app_infos', array(), true);
                $error = new \WP_Error($e->getCode(), $e->getMessage());
                $this->templateManager->displayMessage($error->get_error_message(), 'error', false);
            }
        }
    }

    /**
     * Application infos content
     */
    public function appInfosContent()
    {

        $infos = $this->options['app_infos'];

        if (empty($infos)) {
            $error = new \WP_Error('AWD_facebook_not_ready', __('You must set a valid Facebook Application ID and Secret Key and your Facebook User ID in settings.', self::PTD));
            echo $error->get_error_message();
            echo '<br /><a href="#" id="reload_app_infos" class="btn btn-danger" data-loading-text="<i class=\'icon-time icon-white\'></i> Testing... "><i class="icon-refresh icon-white"></i> ' . __('Reload', self::PTD) . '</a>';
        } else {
            echo '
            <div id="awd_app">
                <div class="alert alert-success"><i class="icon-ok icon-white"></i> ' . __('API SDK Settings are ok', self::PTD) . '</div>
                <table class="table table-condensed">
                    <thead>
                        <th>' . __('Info', self::PTD) . '</th>
                        <th>' . __('Value', self::PTD) . '</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>' . __('Name', self::PTD) . ':</th>
                            <td>' . $infos['name'] . '</td>
                        </tr>
                        <tr>
                            <th>ID:</th>
                            <td>' . $infos['id'] . '</td>
                        </tr>
                        <tr>
                            <th>' . __('Link', self::PTD) . ':</th>
                            <td><a href="' . $infos['link'] . '" target="_blank">View App</a></td>
                        </tr>
                        <tr>
                            <th>' . __('Namespace', self::PTD) . ':</th>
                            <td>' . $infos['namespace'] . '</td>
                        </tr>
                        <tr>
                            <th>' . __('Daily active users', self::PTD) . ':</th>
                            <td class="app_active_users">' . (isset($infos['daily_active_users']) ? $infos['daily_active_users'] : 0) . '</td>
                        </tr>
                        <tr>
                            <th>' . __('Weekly active users', self::PTD) . ':</th>
                            <td class="app_active_users">' . (isset($infos['weekly_active_users']) ? $infos['weekly_active_users'] : 0) . '</td>
                        </tr>
                        <tr>
                            <th>' . __('Monthly active users', self::PTD) . ':</th>
                            <td class="app_active_users">' . (isset($infos['monthly_active_users']) ? $infos['monthly_active_users'] : 0) . '</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><img src="' . $infos['logo_url'] . '" class="thumbnail"/></th>';
            if (current_user_can('manage_facebook_awd_settings')) {
                echo '
                                    <td>
                                        <a href="#" id="reload_app_infos" class="btn btnNormal" data-loading-text="<i class=\'icon-time\'></i> Loading...">
                                            <i class="icon-wrench"></i> ' . __('Test', self::PTD) . '
                                        </a>
                                    </td>';
            } else {
                echo '<td></td>';
            }
            echo '
                        </tr>
                    </tfoot>
                </table>
            </div>';
        }
    }

    /**
     * Admin content
     */
    public function adminContent()
    {
        include_once(dirname(__FILE__) . '/inc/admin/views/admin.php');
    }

    /**
     * Get a html field for media by ajax post
     */
    public function ajaxGetMediaField()
    {
        $label = $_POST['label'];
        $label2 = $_POST['label2'];
        $type = $_POST['type'];
        $name = $_POST['name'];
        $form = new AWD_facebook_form('form_media_field', 'POST', '', self::OPTION_PREFIX);
        echo $form->addMediaButton($label, $name, '', 'span8', array(
            'class' => 'span6'), array(
            'data-title' => $label2,
            'data-type' => $type), true);
        exit();
    }

    /**
     * Activity contents
     */
    public function activityContent()
    {
        $url = parse_url(home_url());
        echo do_shortcode('[AWD_facebook_activitybox domain="' . $url['host'] . '" width="257" height="200" header="false" font="lucida grande" border_color="#F9F9F9" recommendations="1" ref="Facebook AWD Plugin"]');
    }

    /**
     * plugin Options
     */
    public function pluginsContent()
    {
        include_once(dirname(__FILE__) . '/inc/admin/views/admin_plugins.php');
    }

    /**
     * Settings Options
     */
    public function settingsContent()
    {
        include_once(dirname(__FILE__) . '/inc/admin/views/admin_settings.php');
    }

    /**
     * Admin fcbk info content
     */
    public function facebookUserContent()
    {
        if ($this->isUserLoggedInFacebook()) {
            echo do_shortcode('[AWD_facebook_loginbutton width="200" logout_label="<i class=\"icon-off icon-white\"></i> ' . __('Logout', self::PTD) . '" show_profile_picture="1"]');
            $this->templateManager->displayMessage(sprintf(__("%s Facebook ID: %s", self::PTD), '<i class="icon-user"></i> ', $this->uid));
        } elseif ($this->options['connect_enable']) {
            echo '<a href="#" class="AWD_facebook_connect_button btn btn-info" data-redirect="' . $this->getCurrentUrl() . '"><i class="icon-user icon-white"></i> ' . __("Login with Facebook", self::PTD) . '</a>';
        } else {
            $this->templateManager->displayMessage(sprintf(__('You should enable FB connect in %sApp settings%s', self::PTD), '<a href="admin.php?page=' . self::PLUGIN_SLUG . '">', '</a>'), 'warning');
        }
    }

    //****************************************************************************************
    //	OPENGRAPH
    //****************************************************************************************

    /**
     * Filter the html attributes
     * @param  string $languageAttributes
     * @return string
     */
    public function ogpLanguageAttributes($languageAttributes)
    {
        $namespaceUrl = '';
        if (isset($this->options['app_infos']['namespace'])) {
            $namespaceUrl = $this->options['app_infos']['namespace'] . ': http://ogp.me/ns/fb/' . $this->options['app_infos']['namespace'];
        }
        $languageAttributes .= ' prefix="' . \OpenGraphProtocol::PREFIX . ': ' . \OpenGraphProtocol::NS . ' fb:http://ogp.me/ns/fb# ' . $namespaceUrl . '"';

        return $languageAttributes;
    }

    /**
     * Admin page for opengraph settings
     */
    public function openGraphContent()
    {
        include_once(dirname(__FILE__) . '/inc/admin/views/admin_open_graph.php');
    }

    /**
     * Get the opengraph form
     * @param type $objectId
     * @param type $copy
     */
    public function getOpengraphObjectForm($objectId = '', $copy = false)
    {
        include_once(dirname(__FILE__) . '/inc/admin/views/admin_open_graph_form.php');
    }

    /**
     * Get the opengraph form via ajax
     */
    public function ajaxGetOpengraphObjectForm()
    {

        $objectId = $_POST['object_id'];
        $copy = isset($_POST['copy']) ? $_POST['copy'] : false;
        echo $this->getOpengraphObjectForm($objectId, $copy);
        exit();
    }

    /**
     * Admin return an item for object's template list in admin.
     * @param  array  $object
     * @return string
     */
    public function getOpengraphObjectListItem($object)
    {
        return '
        <tr class="awd_object_item_' . $object['id'] . '">
        <td><strong>' . $object['object_title'] . '</strong></td>
        <td>
            <div class="btn-group pull-right" data-object-id="' . $object['id'] . '">
                <button class="btn btn-mini awd_edit_opengraph_object"><i class="icon-edit"></i> ' . __('Edit', self::PTD) . '</button>
                <button class="btn btn-mini awd_edit_opengraph_object copy"><i class="icon-share"></i> ' . __('Copy', self::PTD) . '</button>
                <button class="btn btn-mini awd_delete_opengraph_object btn-warning"><i class="icon-remove icon-white"></i> ' . __('Delete', self::PTD) . '</button>
            </div>
        </td>
        </tr>';
    }

    /**
     * Admin save/update object template
     * @return json array
     */
    public function saveOgpObject()
    {
        if (isset($_POST[self::OPTION_PREFIX . '_nonce_options_save_ogp_object']) && wp_verify_nonce($_POST[self::OPTION_PREFIX . '_nonce_options_save_ogp_object'], self::PLUGIN_SLUG . '_save_ogp_object')) {
            $opengraphObject = array();
            foreach ($_POST[self::OPTION_PREFIX . 'awd_ogp'] as $option => $value) {
                $optionName = str_ireplace(self::OPTION_PREFIX, "", $option);
                //clean empty value.
                if (is_array($value)) {
                    $value = array_filter($value);
                }
                $opengraphObject[$optionName] = $value;
            }

            //verification submitted value
            if ($opengraphObject['object_title'] == '')
                $opengraphObject['object_title'] = __('Default Opengraph Object', self::PTD);

            //Check if the id  of the object was supplied
            if ($opengraphObject['id'] == '')
                $opengraphObject['id'] = rand(0, 9999) . '_' . time();

            if (isset($this->options['opengraph_objects'][$opengraphObject['id']])) {
                $this->options['opengraph_objects'][$opengraphObject['id']] = $opengraphObject;
                //if no object existing, create a new object reference and save it.
            } else {
                $this->options['opengraph_objects'][$opengraphObject['id']] = $opengraphObject;
            }
            //save with option manager
            $this->options['opengraph_objects'] = $this->optionsManager->updateOption('opengraph_objects', $this->options['opengraph_objects'], true);
            echo json_encode(array(
                'success' => 1,
                'item' => $this->getOpengraphObjectListItem($opengraphObject),
                'item_id' => $opengraphObject['id'],
                'links_form' => $this->getOpengraphObjectLinksForm()));
            exit();
        }

        return false;
    }

    /**
     * Delete an opengraph object template
     */
    public function deleteOgpObject()
    {
        $objectId = $_POST['object_id'];
        unset($this->options['opengraph_objects'][$objectId]);

        $this->options['opengraph_objects'] = $this->optionsManager->updateOption('opengraph_objects', $this->options['opengraph_objects'], true);
        echo json_encode(array(
            'success' => 1,
            'count' => count($this->options['opengraph_objects']),
            'links_form' => $this->getOpengraphObjectLinksForm()));
        exit();
    }

    /**
     * Admin Save object relation (ajax post)
     */
    public function saveOgpObjectLinks()
    {
        if (isset($_POST[self::OPTION_PREFIX . '_nonce_options_object_links']) && wp_verify_nonce($_POST[self::OPTION_PREFIX . '_nonce_options_object_links'], self::PLUGIN_SLUG . '_update_object_links')) {
            if ($_POST) {
                $opengraphObjectLinks = array();
                foreach ($_POST[self::OPTION_PREFIX . 'opengraph_object_link'] as $context => $objectId) {
                    $opengraphObjectLinks[$context] = $objectId;
                }
                //save with option manager
                $this->options['opengraph_object_links'] = $this->optionsManager->updateOption('opengraph_object_links', $opengraphObjectLinks, true);

                echo json_encode(array(
                    'success' => 1,
                    'messages' => $this->templateManager->displayMessage(__('Opengraph configuration updated.', self::PTD), 'success', false)));
                exit();
            }
        }
    }

    /**
     * Transform an array into an OpenGraphProtocol object
     * @param  array             $object
     * @return OpenGraphProtocol
     */
    public function opengraphArrayToObject($object)
    {
        $ogp = new \OpenGraphProtocol();
        if (isset($object['locale']))
            $ogp->setLocale($object['locale']);
        else
            $ogp->setLocale($this->options['locale']);
        if (isset($object['site_name']))
            $ogp->setSiteName($object['site_name']);
        if (isset($object['title']))
            $ogp->setTitle($object['title']);
        if (isset($object['description']))
            $ogp->setDescription($object['description']);
        if (isset($object['type'])) {
            if ($object['type'] == 'custom' && isset($object['custom_type']))
                $ogp->setType($object['custom_type']);
            else
                $ogp->setType($object['type']);
        }
        if (isset($object['url']))
            $ogp->setURL($object['url']);
        if (isset($object['determiner']))
            $ogp->setDeterminer($object['determiner']);
        if (isset($object['images'])) {
            if (is_array($object['images']) && count($object['images'])) {
                foreach ($object['images'] as $image_url) {
                    if ($image_url != '') {
                        $ogp_img = $this->createOpengraphProtocolImage($image_url);
                        $ogp->addImage($ogp_img);
                    }
                }
            }
        }
        if (isset($object['videos'])) {
            if (is_array($object['videos']) && count($object['videos'])) {
                foreach ($object['videos'] as $videoUrl) {
                    if ($videoUrl != '') {
                        $ogpVideo = $this->createOpengraphProtocolVideo($videoUrl);
                        $ogp->addVideo($ogpVideo);
                    }
                }
            }
        }
        if (isset($object['audios'])) {
            if (is_array($object['audios']) && count($object['audios'])) {
                foreach ($object['audios'] as $audioUrl) {
                    if ($audioUrl != '') {
                        $ogpAudio = $this->createOpengraphProtocolAudio($audioUrl);
                        $ogp->addAudio($ogpAudio);
                    }
                }
            }
        }

        return $ogp;
    }

    /**
     * Create a OpenGraphProtocolImage object from image url
     *
     * @param  string                 $imageUrl
     * @return OpenGraphProtocolImage
     */
    public function createOpengraphProtocolImage($imageUrl)
    {
        $ogpImg = new \OpenGraphProtocolImage();
        $ogpImg->setURL($imageUrl);

        if ($this->isValidUrl($imageUrl)) {
            //add infos to image
            $imageSize = @getimagesize($imageUrl);
            if (is_array($imageSize)) {
                if (isset($imageSize['mime']))
                    $ogpImg->setType($imageSize['mime']);
                if (isset($imageSize[0]))
                    $ogpImg->setWidth($imageSize[0]);
                if (isset($imageSize[1]))
                    $ogpImg->setHeight($imageSize[1]);
            }
        }
        //check if we want file under ssl
        $urlInfo = parse_url($imageUrl);
        if ($urlInfo) {
            if ($urlInfo['scheme'] == 'https') {
                $secureUrl = $imageUrl;
                $imageUrl = str_replace('https://', 'http://', $imageUrl);
                $ogpImg->setSecureURL($secureUrl);
                $ogpImg->setURL($imageUrl);
            }
        }

        return $ogpImg;
    }

    /**
     * Create a OpenGraphProtocolVideo object from video url
     * @param  string                 $videoUrl
     * @return OpenGraphProtocolVideo
     */
    public function createOpengraphProtocolVideo($videoUrl)
    {
        $ogpVideo = new \OpenGraphProtocolVideo();
        $ogpVideo->setURL($videoUrl);
        //add video infos
        $uploadDir = wp_upload_dir();
        $video_path = str_replace($uploadDir['baseurl'], $uploadDir['basedir'], $videoUrl);
        $getID3 = new \getID3();
        $videoInfos = $getID3->analyze($video_path);
        if (!isset($videoInfos['error'])) {
            if (isset($videoInfos['mime_type']))
                $ogpVideo->setType($videoInfos['mime_type']);

            if (isset($videoInfos['video']['resolution_x']))
                $ogpVideo->setWidth(intval($videoInfos['video']['resolution_x']));

            if (isset($videoInfos['video']['resolution_y'])) {
                $ogpVideo->setHeight(intval($videoInfos['video']['resolution_y']));
            }
        } else {
            //return new \WP_Error('AWD_facebook_opengraphvideo_parser', __('Facebook AWD cannot parse this video file', self::PTD));
        }

        //check if we want file under ssl
        $urlInfo = parse_url($videoUrl);
        if ($urlInfo) {
            if ($urlInfo['scheme'] == 'https') {
                $secureUrl = $videoUrl;
                $videoUrl = str_replace('https://', 'http://', $videoUrl);
                $ogpVideo->setSecureURL($secureUrl);
                $ogpVideo->setURL($videoUrl);
            }
        }

        return $ogpVideo;
    }

    /**
     * Create an OpenGraphProtocolAudio object from audio url
     * @param  string                  $audioUrl
     * @return \OpenGraphProtocolAudio
     */
    public function createOpengraphProtocolAudio($audioUrl)
    {
        $ogpAudio = new \OpenGraphProtocolAudio();
        $ogpAudio->setURL($audioUrl);
        //add video infos
        $uploadDir = wp_upload_dir();
        $audioPath = str_replace($uploadDir['baseurl'], $uploadDir['basedir'], $audioUrl);
        $getID3 = new \getID3();
        $audioInfos = $getID3->analyze($audioPath);
        if (!isset($audioInfos['error'])) {
            if (isset($audioInfos['mime_type']))
                $ogpAudio->setType($audioInfos['mime_type']);
        } else {
            //return new \WP_Error('AWD_facebook_opengraphvideo_parser', __('Facebook AWD cannot parse this video file', self::PTD));
        }
        //check if we want file under ssl
        $urlInfo = parse_url($audioUrl);
        if ($urlInfo) {
            if ($urlInfo['scheme'] == 'https') {
                $secureUrl = $audioUrl;
                $audioUrl = str_replace('https://', 'http://', $audioUrl);
                $ogpAudio->setSecureURL($secureUrl);
                $ogpAudio->setURL($audioUrl);
            }
        }

        return $ogpAudio;
    }

    /**
     * Test if url return 200
     * @param  string  $url
     * @return boolean
     */
    public function isValidUrl($url)
    {
        //test image if image exist
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($retcode == '200' OR $retcode == '302')
            return true;

        return false;
    }

    /**
     * Admin Form to link object to post type.
     * @return string $html
     */
    public function getOpengraphObjectLinksForm()
    {
        $html = '';
        $form = new AWD_facebook_form('form_create_opengraph_object_links', 'POST', '', self::OPTION_PREFIX);
        $ogpObjects = apply_filters('AWD_facebook_ogp_objects', $this->options['opengraph_objects']);
        $pageContexts = $this->options['opengraph_contexts'];
        $taxonomies = get_taxonomies(array('public' => true, 'show_ui' => true), 'objects');

        if (!empty($taxonomies)) {
            foreach ($taxonomies as $key => $taxValues) {
                $pageContexts[$taxValues->name] = $taxValues->label;
            }
        }

        $postypesMedia = get_post_types(array('name' => 'attachment'), 'objects');
        $postypes = get_post_types(array('show_ui' => true), 'objects');

        if (is_object($postypesMedia['attachment']))
            $postypes['attachment'] = $postypesMedia['attachment'];

        unset($postypes['post']);
        unset($postypes['page']);
        if (!empty($postypes)) {
            foreach ($postypes as $key => $posttypeValues) {
                $pageContexts[$posttypeValues->name] = $posttypeValues->label;
            }
        }

        $html .= $form->start();
        if (is_array($ogpObjects) && count($ogpObjects)) {
            $html .= $this->templateManager->displayMessage(__('Select the object to use with type of pages.', self::PTD), 'info', false);

            foreach ($pageContexts as $key => $context) {
                $options = array();
                $options[] = array(
                    'value' => '',
                    'label' => __('Disabled', self::PTD));
                $linkedObject = isset($this->options['opengraph_object_links'][$key]) ? $this->options['opengraph_object_links'][$key] : '';
                foreach ($ogpObjects as $value => $ogpObject) {
                    $options[] = array(
                        'value' => $value,
                        'label' => $ogpObject['object_title']);
                }
                $html .= $form->addSelect(__('Choose Opengraph object for', self::PTD) . ' ' . $context, 'opengraph_object_link[' . $key . ']', $options, $linkedObject, 'span4', array('class' => 'span4'));
            }
        } else {
            $html .= $this->templateManager->displayMessage(__('No Object found', self::PTD), 'warning', false);
        }
        $html .= wp_nonce_field(self::PLUGIN_SLUG . '_update_object_links', self::OPTION_PREFIX . '_nonce_options_object_links', null, false);
        $html .= $form->end();

        return $html;
    }

    /**
     * Helper to get html opengraph tags by post id.
     * @param  integer $postId
     * @return string  $html
     */
    public function getOgpTags($postId)
    {
        $args = array('p' => $postId);
        $the_query = new \WP_Query($args);
        $html = '';
        while ($the_query->have_posts()) :
            $the_query->the_post();
            $html = $this->defineOgpObjects();
        endwhile;
        wp_reset_postdata();

        return $html;
    }

    /**
     * Helper to display html opengraph tags depending on the current WP_query.
     * This function is called by hook wp_head.
     */
    public function displayOgpObjects()
    {
        echo $this->defineOgpObjects();
    }

    /**
     * Helper to get a descrtion from the post.
     * @param WP_Post
     * @return string
     */
    public function getPostDescription($post)
    {
        if (!empty($post->post_excerpt)) {
            $description = esc_attr(str_replace("\r\n", ' ', substr(strip_tags(strip_shortcodes($post->post_excerpt)), 0, 160)));
        } else {
            $description = esc_attr(str_replace("\r\n", ' ', substr(strip_tags(strip_shortcodes($post->post_content)), 0, 160)));
        }

        return $description;
    }

    /**
     * Helper to get a post thumbnail
     * @param WP_Post
     * @return string
     */
    public function getPostThumbnail($post)
    {
        $img = '';
        if (current_theme_supports('post-thumbnails')) {
            if (has_post_thumbnail($post->ID)) {
                $img = $this->templateManager->catchFisrtImage(get_the_post_thumbnail($post->ID, 'AWD_facebook_ogimage'));
            }
        }
        if (empty($img))
            $img = $this->templateManager->catchFisrtImage($post->post_content);

        if (empty($img)) {
            if (isset($this->options['app_infos']['logo_url'])) {
                $img = $this->options['app_infos']['logo_url'];
            }
        }

        return $img;
    }

    /**
     * Define the relating tags on the current page/post/...
     * @return string $html
     */
    public function defineOgpObjects()
    {
        global $wp_query, $post;

        $blogName = get_bloginfo('name');
        $blogDescription = str_replace(array("\n", "\r"), "", get_bloginfo('description'));
        $homeUrl = home_url();
        $linkedObject = null;
        $arrayReplace = array();

        switch (1) {
            case is_front_page():
            case is_home():
                $arrayReplace = array($blogName, $blogDescription, $homeUrl);
                //if home page is a single page add some value in pattern
                if (is_page($post->ID)) {
                    $arrayReplace = array(
                        $blogName,
                        $blogDescription,
                        $homeUrl,
                        $post->post_title,
                        $this->getPostDescription($post),
                        $this->getPostThumbnail($post),
                        get_permalink($post->ID)
                    );
                }
                $linkedObject = isset($this->options['opengraph_object_links']['frontpage']) ? $this->options['opengraph_object_links']['frontpage'] : null;
                break;

            case is_author():
                $linkedObject = isset($this->options['opengraph_object_links']['author']) ? $this->options['opengraph_object_links']['author'] : null;
                $currentAuthor = get_user_by('slug', $wp_query->query_vars['author_name']);
                $avatar = get_avatar($currentAuthor->ID, '200');

                if ($avatar)
                    $gravatarAttributes = simplexml_load_string($avatar);

                if (!empty($gravatarAttributes['src']))
                    $gravatar_url = $gravatarAttributes['src'];

                $arrayReplace = array(
                    $blogName,
                    $blogDescription,
                    $homeUrl,
                    trim(wp_title('', false)),
                    $currentAuthor->description,
                    $gravatar_url,
                    $this->getCurrentUrl()
                );
                break;

            case is_archive():
                switch (1) {
                    case is_tag():
                        $linkedObject = isset($this->options['opengraph_object_links']['post_tag']) ? $this->options['opengraph_object_links']['post_tag'] : null;
                        $arrayReplace = array(
                            $blogName,
                            $blogDescription,
                            $homeUrl,
                            trim(wp_title('', false)),
                            '',
                            '',
                            $this->getCurrentUrl()
                        );
                        break;

                    case is_tax():
                        $taxonomySlug = $wp_query->query_vars['taxonomy'];
                        $linkedObject = isset($this->options['opengraph_object_links'][$taxonomySlug]) ? $this->options['opengraph_object_links'][$taxonomySlug] : null;
                        $arrayReplace = array(
                            $blogName,
                            $blogDescription,
                            $homeUrl,
                            trim(wp_title('', false)),
                            term_description(),
                            '',
                            $this->getCurrentUrl()
                        );
                        break;

                    case is_category():
                        $linkedObject = isset($this->options['opengraph_object_links']['category']) ? $this->options['opengraph_object_links']['category'] : null;
                        $arrayReplace = array(
                            $blogName,
                            $blogDescription,
                            $homeUrl,
                            trim(wp_title('', false)),
                            category_description(),
                            '',
                            $this->getCurrentUrl()
                        );
                        break;

                    default:
                        $linkedObject = isset($this->options['opengraph_object_links']['archive']) ? $this->options['opengraph_object_links']['archive'] : null;
                        $arrayReplace = array(
                            $blogName,
                            $blogDescription,
                            $homeUrl,
                            trim(wp_title('', false)),
                            '',
                            '',
                            $this->getCurrentUrl()
                        );
                        break;
                }
                break;

            case is_attachment():
                $linkedObject = isset($this->options['opengraph_object_links']['attachment']) ? $this->options['opengraph_object_links']['attachment'] : null;
                $arrayReplace = array(
                    $blogName,
                    $blogDescription,
                    $homeUrl,
                    trim(wp_title('', false)),
                    '',
                    '',
                    $this->getCurrentUrl()
                );
                break;

            case is_page():
            case is_single():
                $linkedObject = isset($this->options['opengraph_object_links'][(is_single() ? 'post' : 'page')]) ? $this->options['opengraph_object_links'][(is_single() ? 'post' : 'page')] : null;
                $arrayReplace = array(
                    $blogName,
                    $blogDescription,
                    $homeUrl,
                    $post->post_title,
                    $this->getPostDescription($post),
                    $this->getPostThumbnail($post),
                    get_permalink($post->ID)
                );
                break;
        }

        //redefine object template from post if value is set
        $definedFromPost = 0;
        $objectTemplate = null;

        if (is_object($post)) {
            $custom = get_post_meta($post->ID, self::PLUGIN_SLUG, true);
            if (!is_string($custom) AND isset($custom['opengraph']['object_link'])) {
                if ($custom['opengraph']['object_link'] == 'custom') {
                    $definedFromPost = 1;
                    $objectTemplate = $custom['awd_ogp'];
                } elseif ($custom['opengraph']['object_link'] != '') {
                    $definedFromPost = 1;
                    $linkedObject = $custom['opengraph']['object_link'];
                }
            }
        }
        //define object template depending on object values
        if ($objectTemplate === null)
            $objectTemplate = isset($this->options['opengraph_objects'][$linkedObject]) ? $this->options['opengraph_objects'][$linkedObject] : null;

        //Process all pattern.
        $objectTemplate = $this->processOpengraphPattern($arrayReplace, $objectTemplate);

        if ($objectTemplate != null) {
            if (is_object($post)) {
                //auto load images attachment
                if (!empty($objectTemplate['auto_load_images_attachment'])) {
                    $images = array();
                    if ($objectTemplate['auto_load_images_attachment'] == 1) {
                        $attachmentsImages = get_posts(array(
                            'post_type' => 'attachment',
                            'posts_per_page' => -1,
                            'post_parent' => $post->ID,
                            'post_mime_type' => 'image/*')
                        );
                        if ($attachmentsImages) {
                            foreach ($attachmentsImages as $attachmentsImage) {
                                $images[] = wp_get_attachment_url($attachmentsImage->ID);
                            }
                        }
                    }
                    $objectTemplate['images'] = array_merge($images, $objectTemplate['images']);
                }

                //auto load videos attachment
                if (!empty($objectTemplate['auto_load_videos_attachment'])) {
                    $videos = array();
                    if ($objectTemplate['auto_load_videos_attachment'] == 1) {
                        $attachmentsVideos = get_posts(array(
                            'post_type' => 'attachment',
                            'posts_per_page' => -1,
                            'post_parent' => $post->ID,
                            'post_mime_type' => array(
                                'video/*'
                            )
                        ));
                        if ($attachmentsVideos) {
                            foreach ($attachmentsVideos as $attachmentsVideo) {
                                $videos[] = wp_get_attachment_url($attachmentsVideo->ID);
                            }
                        }
                        $objectTemplate['videos'] = array_merge($videos, $objectTemplate['videos']);
                    }
                }

                //auto load audios attachment
                if (!empty($objectTemplate['auto_load_audios_attachment'])) {
                    $audios = array();
                    if ($objectTemplate['auto_load_audios_attachment'] == 1) {
                        $attachmentsAudios = get_posts(array(
                            'post_type' => 'attachment',
                            'posts_per_page' => -1,
                            'post_parent' => $post->ID,
                            'post_mime_type' => array(
                                'audio/*'
                            )
                        ));
                        if ($attachmentsAudios) {
                            foreach ($attachmentsAudios as $attachmentsAudio) {
                                $audios[] = wp_get_attachment_url($attachmentsAudio->ID);
                            }
                        }
                        $objectTemplate['audios'] = array_merge($audios, $objectTemplate['audios']);
                    }
                }
            }

            return $this->renderOgpTags($objectTemplate, $definedFromPost);
        }

        return false;
    }

    /**
     * Replace all the pattern by related content
     *
     * @param  array $arrayReplace
     * @param  array $objectTemplate
     * @return array
     */
    public function processOpengraphPattern($arrayReplace, $objectTemplate)
    {
        $arrayPattern = array(
            "%BLOG_TITLE%",
            "%BLOG_DESCRIPTION%",
            "%BLOG_URL%",
            "%TITLE%",
            "%DESCRIPTION%",
            "%IMAGE%",
            "%URL%");
        if (is_array($objectTemplate)) {
            foreach ($objectTemplate as $field => $value) {
                $value = str_replace($arrayPattern, $arrayReplace, $value);
                $objectTemplate[$field] = $value;
            }
        }

        return $objectTemplate;
    }

    /**
     * Render opengraph tags, replace pattern by value depending on linked_object
     * @param  array   $objectTemplate
     * @param  boolean $definedFromPost
     * @return string
     */
    public function renderOgpTags($objectTemplate, $definedFromPost = 0)
    {
        //construct related ogp object
        $ogp = $this->opengraphArrayToObject($objectTemplate);
        $html = '<!-- ' . self::PLUGIN_NAME . ' Opengraph [v' . $this->getVersion() . '] (object reference: "' . $objectTemplate['object_title'] . '" ' . ($definedFromPost == 1 ? 'Defined from post' : '') . ') -->' . "\n";
        if ($this->options['app_id'] != '')
            $html .= '<meta property="fb:app_id" content="' . $this->options['app_id'] . '" />' . "\n";
        if ($this->options['admins'] != '')
            $html .= '<meta property="fb:admins" content="' . $this->options['admins'] . '" />' . "\n";
        $html .= $ogp->toHTML();
        $html .= "\n" . '<!-- ' . self::PLUGIN_NAME . ' END Opengraph -->' . "\n";

        return $html;
    }

    //****************************************************************************************
    //	FRONT AND CONTENT
    //****************************************************************************************

    /**
     * The Filter on the content to add like button
     *
     * @param  string $content
     * @return string $content
     */
    public function filterContent($content)
    {
        global $post;
        $excludePostType = explode(",", $this->options['likebutton']['exclude_post_type']);
        $excludePostPageId = explode(",", $this->options['likebutton']['exclude_post_id']);
        $excludeTermsSlug = explode(",", $this->options['likebutton']['exclude_terms_slug']);

        //define the like button
        $url = get_permalink($post->ID);
        $likebutton = do_shortcode('[AWD_facebook_likebutton href="' . $url . '"]');

        //get all terms for the post
        $args = array();
        $taxonomies = get_taxonomies($args, 'objects');
        $terms = array();
        if ($taxonomies) {
            foreach ($taxonomies as $taxonomy) {
                $tempTerms = get_the_terms($post->ID, $taxonomy->name);
                if ($tempTerms) {
                    foreach ($tempTerms as $tempTerm) {
                        if ($tempTerm) {
                            $terms[] = $tempTerm->slug;
                            $terms[] = $tempTerm->term_id;
                        }
                    }
                }
            }
        }
        //say if we need to exclude this post for terms
        $isTermToExclude = false;
        if ($terms)
            foreach ($terms as $term) {
                if (in_array($term, $excludeTermsSlug))
                    $isTermToExclude = true;
            }

        $custom = get_post_meta($post->ID, self::PLUGIN_SLUG, true);
        if (!is_array($custom)) {
            $custom = array();
        }
        $options = array_merge($this->options['content_manager'], $custom);

        //enable by default like button
        if (isset($options['likebutton']['redefine']) && $options['likebutton']['redefine'] == 1) {
            if ($options['likebutton']['enabled'] == 1) {
                if ($options['likebutton']['place'] == 'bottom')
                    return $content . $likebutton;
                elseif ($options['likebutton']['place'] == 'both')
                    return $likebutton . $content . $likebutton;
                elseif ($options['likebutton']['place'] == 'top')
                    return $likebutton . $content;
            } else {
                return $content;
            }
        } elseif (
        //if
        //no in posts to exclude
                !in_array($post->post_type, $excludePostType)
                //no in pages to exclude
                && !in_array($post->ID, $excludePostPageId)
                //no in terms to exclude
                && !$isTermToExclude) {
            if ($post->post_type == 'page' && $this->options['likebutton']['on_pages']) {
                if ($this->options['likebutton']['place_on_pages'] == 'bottom')
                    return $content . $likebutton;
                elseif ($this->options['likebutton']['place_on_pages'] == 'both')
                    return $likebutton . $content . $likebutton;
                elseif ($this->options['likebutton']['place_on_pages'] == 'top')
                    return $likebutton . $content;
            } elseif ($post->post_type == 'post' && $this->options['likebutton']['on_posts']) {
                if ($this->options['likebutton']['place_on_posts'] == 'bottom')
                    return $content . $likebutton;
                elseif ($this->options['likebutton']['place_on_posts'] == 'both')
                    return $likebutton . $content . $likebutton;
                elseif ($this->options['likebutton']['place_on_posts'] == 'top')
                    return $likebutton . $content;
            } elseif (in_array($post->post_type, get_post_types(array(
                        'public' => true,
                        '_builtin' => false))) && $this->options['likebutton']['on_custom_post_types']) {
                //for other custom post type
                if ($this->options['likebutton']['place_on_custom_post_types'] == 'bottom')
                    return $content . $likebutton;
                elseif ($this->options['likebutton']['place_on_custom_post_types'] == 'both')
                    return $likebutton . $content . $likebutton;
                elseif ($this->options['likebutton']['place_on_custom_post_types'] == 'top')
                    return $likebutton . $content;
            }
        }

        return $content;
    }

    //****************************************************************************************
    //	PUBLISH TO FACEBOOK
    //****************************************************************************************

    /**
     * Publish a wordpress post to facebook pages, or facebook timeline
     * @param WP_Post $post
     */
    public function publishPostToFacebookHook($post)
    {
        //check if the post is published
        if ($post->post_status == 'publish') {

            //Publish to Graph api
            $options = get_post_meta($post->ID, "awd_fcbk", true);
            $publish = isset($options["fbpublish"]) ? 1 : 0;

            if ($publish) {
                $publishOptions = $options["fbpublish"];

                $message = $publishOptions['message_text'];
                $readMoreText = $publishOptions['read_more_text'];

                //Check if we want to publish on facebook pages and profile as anonimous, access token  stored inside options.
                if ($publishOptions['to_pages'] == 1) {
                    $pages = $this->getPagesToPublish($post->post_author);
                    if (count($pages) > 0) {
                        $this->publishPostToFacebook($pages, $post->ID, $message, $readMoreText);
                    }
                }

                //Check if we want to publish on profile
                if ($this->isUserLoggedInFacebook()) {
                    if ($publishOptions['to_profile'] == 1 && $this->currentFacebookUserCan('publish_stream')) {
                        $this->publishPostToFacebook($this->uid, $post->ID, $message, $readMoreText);
                    }
                }
            }
        }
    }

    /**
     * Return all pages selected by user to publish on.
     * @param  type  $userId
     * @return array
     */
    public function getPagesToPublish($userId = null)
    {
        //First try to get the pages of the current user.
        if ($userId == null) {
            $me = $this->me;
        } else {
            $me = get_user_meta($userId, "fb_user_infos", true);
        }
        $pages = array();
        if (isset($me['pages'])) {
            $pages = $me['pages'];
        }
        $publishToPages = array();
        foreach ($pages as $page) {
            //if pages are in the array of option to publish on,
            if (isset($this->options['fb_publish_to_pages'][$page['id']])) {
                if ($this->options['fb_publish_to_pages'][$page['id']] == 1) {
                    $newPage = array();
                    $newPage['id'] = $page['id'];
                    $newPage['access_token'] = $page['access_token'];
                    $publishToPages[] = $newPage;
                }
            }
        }

        return $publishToPages;
    }

    /**
     * Publish the WP_Post to facebook
     * @param  array            $toPages
     * @param  integer          $postId
     * @param  string           $message
     * @param  string           $readMoreText
     * @return \WP_Error|string
     */
    public function publishPostToFacebook($toPages, $postId, $message = null, $readMoreText = null)
    {
        $permalink = get_permalink($postId);
        $result = 'success';
        if (is_array($toPages) && count($toPages) > 0) {
            foreach ($toPages as $fbpage) {
                $feedPath = '/' . $fbpage['id'] . '/feed/';
                $params = array(
                    'access_token' => $fbpage['access_token'],
                    'message' => stripcslashes($message),
                    'link' => $permalink
                );
                if (!empty($readMoreText)) {
                    $params['actions'] = array(
                        array(
                            'name' => stripcslashes($readMoreText),
                            'link' => $permalink
                        )
                    );
                }
                try {
                    //try to post batch request to publish on all pages asked + profile at one time
                    $postId = $this->fcbk->api($feedPath, 'POST', $params);

                    return $postId;
                } catch (FacebookApiException $e) {
                    $error = new \WP_Error($e->getCode(), $e->getMessage());

                    return $error;
                }
            }
        } elseif (is_int(absint($toPages))) {
            $feedPath = '/' . $toPages . '/feed/';
            $params = array(
                'message' => $message,
                'link' => $permalink,
                'actions' => array(
                    array(
                        'name' => $readMoreText,
                        'link' => $permalink
                    )
            ));
            try {
                //try to post batch request to publish on profile
                $postId = $this->fcbk->api($feedPath, 'POST', $params);

                return $postId;
            } catch (FacebookApiException $e) {
                $error = new \WP_Error($e->getCode(), $e->getMessage());

                return $error;
            }
        }

        return $result;
    }

    /**
     * Update options when settings are updated.
     * @return boolean
     */
    public function updateSettingsFromPost()
    {
        if ($_POST) {
            $newOptions = array();
            foreach ($_POST as $option => $value) {
                $optionName = str_ireplace(self::OPTION_PREFIX, "", $option);
                $newOptions[$optionName] = $value;
            }
            $this->optionsManager->setOptions($newOptions);
            $this->optionsManager->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Handle the Settings update post.
     */
    public function handleSettingsUpdate()
    {
        if (isset($_POST[self::OPTION_PREFIX . '_nonce_options_update_field']) && wp_verify_nonce($_POST[self::OPTION_PREFIX . '_nonce_options_update_field'], self::PLUGIN_SLUG . '_update_options')) {
            //do custom action for sub plugins or other exec.
            do_action('AWD_facebook_save_custom_settings');
            //unset submit to not be stored
            unset($_POST[self::OPTION_PREFIX . '_nonce_options_update_field']);
            unset($_POST['_wp_http_referer']);
            if ($this->updateSettingsFromPost()) {
                $this->getAppInfos();
                $this->templateManager->addMessage('success', __('Options updated', self::PTD) . ' <a class="btn btn-success" href="' . wp_get_referer() . '">' . __('Reload the page to see changes', self::PTD) . '</a>');
            } else {
                $this->templateManager->addError(new \WP_Error('AWD_facebook_save_option', __('Options not updated there is an error...', self::PTD)));
            }
        } elseif (isset($_POST[self::OPTION_PREFIX . '_nonce_reset_options']) && wp_verify_nonce($_POST[self::OPTION_PREFIX . '_nonce_reset_options'], self::PLUGIN_SLUG . '_reset_options')) {
            $this->optionsManager->reset();
            $this->templateManager->addMessage('success', __('Options were reseted', self::PTD));
        }
    }

    /**
     * Handle the Settings update ajax post.
     */
    public function ajaxHandleSettingsUpdate()
    {
        $this->handleSettingsUpdate();
        $notices = $this->templateManager->displayNotices(false);
        $response = array(
            'success' => true,
            'notices' => $notices,
        );
        echo json_encode($response);
        exit();
    }

    //****************************************************************************************
    //	USER PROFILE
    //****************************************************************************************

    /**
     * Add FB capabalities to default WP roles
     */
    public function setAdminRoles()
    {
        $roles = array(
            'administrator' => array(
                'manage_facebook_awd_settings',
                'manage_facebook_awd_plugins',
                'manage_facebook_awd_opengraph',
                'manage_facebook_awd_publish_to_pages'
            ),
            'editor' => array(
                'manage_facebook_awd_publish_to_pages',
                'manage_facebook_awd_opengraph'
            ),
            'author' => array(
                'manage_facebook_awd_publish_to_pages'
            )
        );
        $roles = apply_filters('AWD_facebook_admin_roles', $roles);
        foreach ($roles as $role => $caps) {
            $wp_role = get_role($role);
            foreach ($caps as $cap) {
                $wp_role->add_cap($cap);
            }
        }
    }

    /**
     * Get current URL
     * @return string
     */
    public function getCurrentUrl()
    {
        return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * Add facebook fields in user profile
     * @param  WP_User $user
     * @return string
     */
    public function userProfileEdit($user)
    {

        if (current_user_can('read')) {
            echo '
            <h3>' . __('Facebook infos', self::PTD) . '</h3>
            <table class="form-table">
                <tr>
                    <th><label for="fb_email">' . __('Facebook Email', self::PTD) . '</label></th>
                    <td>
                        <input type="text" name="fb_email" id="fb_email" value="' . esc_attr(get_user_meta($user->ID, 'fb_email', true)) . '" class="regular-text" /><br />
                        <span class="description">' . __('Enter your Facebook Email', self::PTD) . '</span>
                    </td>
                </tr>
                <tr>
                    <th><label for="fb_uid">' . __('Facebook ID', self::PTD) . '</label></th>
                    <td>
                        <input type="text" name="fb_uid" id="fb_uid" value="' . esc_attr(get_user_meta($user->ID, 'fb_uid', true)) . '" class="regular-text" /><br />
                        <span class="description">' . __('Enter your Facebook ID', self::PTD) . '</span>
                    </td>
                </tr>
                <tr>
                    <th><label for="fb_reset">' . __('Unsync Facebook Account ?', self::PTD) . '</label></th>
                    <td>
                        <input type="checkbox" name="fb_reset" id="fb_reset" value="1" /><br />
                        <span class="description">' . __('Note: This will clear all your facebook data linked with this account.', self::PTD) . '</span>
                    </td>
                </tr>
            </table>';
        }
    }

    /**
     * Handle the user profile update post
     * @param integer $userId
     */
    public function handleUserProfileUpdate($userId)
    {
        if (!current_user_can('read', $userId))
            return false;
        if (isset($_POST['fb_reset'])) {
            wp_redirect($this->_unsync_url);
            exit();
        }
        if (isset($_POST['fb_email'])) {
            update_user_meta($userId, 'fb_email', $_POST['fb_email']);
        }
        if (isset($_POST['fb_uid'])) {
            update_user_meta($userId, 'fb_uid', $_POST['fb_uid']);
        }
    }

    //****************************************************************************************
    //	Facebook CONNECT
    //****************************************************************************************

    /**
     * Return the WP_User by facebook uid
     * @param  type             $fbUid
     * @return \WP_User|boolean
     */
    public function getUserFromFbuid($fbUid)
    {
        $existingUser = $this->wpdb->get_var('SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $fbUid . '" )  LIMIT 1 ');
        if ($existingUser) {
            $user = get_userdata($existingUser);

            return $user;
        } else {
            return false;
        }
    }

    /**
     * Return all facebook users register in the database
     * @return array
     */
    public function getFacebookUsers()
    {
        $existingUsers = $this->wpdb->get_results('SELECT DISTINCT `u`.`ID`,`u`.`display_name`,`m`.`meta_value`   FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` !="" )');

        return $existingUsers;
    }

    /**
     * Filter the wordpress avatar adding the facebook one.
     * @param  string                  $avatar
     * @param  string|integer|\WP_User $commentsObjects
     * @param  string                  $size
     * @param  string                  $default
     * @param  string                  $alt
     * @return string
     */
    public function getFacebookAvatar($avatar, $commentsObjects, $size, $default, $alt)
    {
        $fbuid = 0;
        if (is_object($commentsObjects)) {
            $fbuid = get_user_meta($commentsObjects->user_id, 'fb_uid', true);
            if ($fbuid == '') {
                $fbuid = $commentsObjects->user_id; //try if we directly get fbuid
            }
        } elseif (is_numeric($commentsObjects)) {
            $fbuid = get_user_meta($commentsObjects, 'fb_uid', true);
        } elseif ($commentsObjects != '') {
            if ($default == 'awd_fcbk') {
                $user = get_user_by('email', $commentsObjects);
                $fbuid = get_user_meta($user->ID, 'fb_uid', true);
            }
        }
        if ($fbuid != '' && $fbuid != 0) {
            if ($size <= 70) {
                $type = 'square';
            } elseif ($size > 70) {
                $type = 'normal';
            } else {
                $type = 'large';
            }
            $fbAvatarUrl = 'http://graph.facebook.com/' . $fbuid . '/picture' . ($type != '' ? '?type=' . $type : '');
            $myAvatar = "<img src='" . $fbAvatarUrl . "' class='avatar AWD_fbavatar' alt='" . $alt . "' height='" . $size . "' />";

            return $myAvatar;
        }

        return $avatar;
    }

    /**
     * Test if a Facebook user can perform an action
     * @param  string  $perm
     * @return boolean
     */
    public function currentFacebookUserCan($perm)
    {
        if ($this->isUserLoggedInFacebook()) {
            if (isset($this->me['permissions']) && is_array($this->me['permissions'])) {
                if (isset($this->me['permissions'][$perm]) && $this->me['permissions'][$perm] == 1)
                    return true;
            }
        }

        return false;
    }

    /**
     * Return the Facebook user by facebook uid
     * @param  integer         $fbuid
     * @return \WP_Error|array
     */
    public function getFbUser($fbuid)
    {
        try {
            $fbuser = $this->fcbk->api('/' . $fbuid, 'GET');

            return $fbuser;
        } catch (FacebookApiException $e) {
            $fbError = $e->getResult();
            $error = new \WP_Error(403, self::PLUGIN_NAME . ' Error: ' . $fbError['error']['type'] . ' ' . $fbError['error']['message']);

            return $error;
        }
    }

    /**
     * Return the Facebook user's permissions by facebook uid
     * @param  type            $fbuid
     * @return \WP_Error|array
     */
    public function getPermissions($fbuid)
    {
        $perms = array();
        try {
            $perms = $this->fcbk->api('/' . $fbuid . '/permissions');
            $perms = isset($perms['data'][0]) ? $perms['data'][0] : array();

            return $perms;
        } catch (FacebookApiException $e) {
            $fbError = $e->getResult();
            $error = new \WP_Error(403, self::PLUGIN_NAME . ' Error: ' . $fbError['error']['type'] . ' ' . $fbError['error']['message']);

            return $error;
        }
    }

    /**
     * Return the realtime api subscriptions detected by the plugin
     * @return \WP_Error|array
     */
    public function getRealtimeSubscriptions()
    {
        $sub = array();
        try {
            if (is_object($this->fcbk)) {
                $sub = $this->fcbk->api('/' . $this->options['app_id'] . '/subscriptions', 'GET', array("access_token" => $this->fcbk->getApplicationAccessToken()));
            } else {
                $error = new \WP_Error(500, self::PLUGIN_NAME . " Api not configured");

                return $error;
            }
            $sub = isset($sub['data']) ? $sub['data'] : array();

            return $sub;
        } catch (FacebookApiException $e) {
            $fbError = $e->getResult();
            $error = new \WP_Error(403, self::PLUGIN_NAME . ' Error: ' . $fbError['error']['type'] . ' ' . $fbError['error']['message']);

            return $error;
        }
    }

    /**
     * Return the facebook pages of the current user.
     * @return \WP_Error|array
     */
    public function getFbPages()
    {
        try {
            $fbPages = $this->fcbk->api('/me/accounts');

            return $fbPages;
        } catch (FacebookApiException $e) {
            $fbError = $e->getResult();
            $error = new \WP_Error(403, self::PLUGIN_NAME . ' Error: ' . $fbError['error']['type'] . ' ' . $fbError['error']['message']);

            return $error;
        }
    }

    /**
     * Get all facebook user datas.
     * @param  type $fbuid
     * @return type
     */
    public function getFacebookUserData($fbuid)
    {
        //Set the /me data
        $me = $this->getFbUser($this->uid);
        if (is_wp_error($me)) {
            return $me;
        }

        //set the /me/permissions data
        $perms = $this->getPermissions($this->uid);
        if (is_wp_error($perms))
            return $perms;
        $me['permissions'] = $perms;

        if (isset($me['permissions']['manage_pages'])) {
            if ($me['permissions']['manage_pages'] == 1) {
                $pages = $this->getFbPages($this->uid);
                if (is_wp_error($pages))
                    return $pages;
                if (isset($pages['data'])) {
                    foreach ($pages['data'] as $fbPage) {
                        $me['pages'][$fbPage['id']] = $fbPage;
                    }
                }
            }
        }

        return $me;
    }

    /**
     * Load the current user data into $me property
     * @param integer $wpUserId
     */
    public function initFacebookUserData($wpUserId)
    {
        $this->me = get_user_meta($wpUserId, 'fb_user_infos', true);
    }

    /**
     * Update the user facebook data
     * @param integer $wpUserId
     * @param array   $data
     */
    public function updateFacebookUserData($wpUserId, array $data)
    {
        update_user_meta($wpUserId, 'fb_email', $data['email']);
        update_user_meta($wpUserId, 'fb_uid', $data['id']);
        update_user_meta($wpUserId, 'fb_user_infos', $data);
    }

    /**
     * Delete the user facebook data
     * @param array $wpUserId
     */
    public function deleteFacebookUserData($wpUserId)
    {
        delete_user_meta($wpUserId, 'fb_email');
        delete_user_meta($wpUserId, 'fb_user_infos');
        delete_user_meta($wpUserId, 'fb_uid');
    }

    /**
     * Get the WP_User ID from current Facebook User
     * @return boolean|integer
     */
    public function getExistingUserFromFacebook()
    {
        $existing_user = $this->wpdb->get_var('SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`
        WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` ="' . $this->uid . '")
        OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value`="' . $this->me['email'] . '") OR (`u`.`user_email` = "' . $this->me['email'] . '")  LIMIT 1 ');
        if (empty($existing_user))
            $existing_user = false;

        return $existing_user;
    }

    /**
     * Detect if the current user is logged in using facebook provider
     * @return boolean
     */
    public function isUserLoggedInFacebook()
    {
        if (isset($this->uid) && $this->uid != 0 && count($this->me)) {
            return true;
        }

        return false;
    }

    /**
     * Init of the facebook php sdk.
     */
    public function initFacebookPhpSdk()
    {
        $this->setFcbk(new AWD_facebook_api($this->options));
        $this->setUid($this->fcbk->getUser());
        $this->initFacebookUserData($this->getCurrentUser()->ID);

        //helpers vars.
        $login_options = array(
            'scope' => current_user_can("manage_options") ? $this->options["perms_admin"] : $this->options["perms"],
            'redirect_uri' => $this->_login_url . (get_option('permalink_structure') != '' ? '?' : '&') . 'redirect_to=' . $this->getCurrentUrl()
        );

        $this->_oauth_url = $this->fcbk->getLoginUrl($login_options);
    }

    /**
     * Inititlize the Facebook Javascript SDK
     */
    public function initFacebookJavascriptSDK()
    {
        $html = "\n" . '
        <!-- ' . self::PLUGIN_NAME . ' Facebook Library Library-->
        <div id="fb-root"></div>
        <script type="text/javascript">
            (function (d) {
                var js, id = "facebook-jssdk",
                ref = d.getElementsByTagName("script")[0];
                if (d.getElementById(id)) {
                        return;
                }
                js = d.createElement("script");
                js.id = id; js.async = true;
                js.src = "//connect.facebook.net/' . $this->options['locale'] . '/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));';

        if ($this->options['connect_enable'] == 1) {
            $html .= '
            jQuery(document).ready(function () {
                window.fbAsyncInit = function () {
                    FB.init({
                            appId : awd_fcbk.app_id,
                            channelUrl : "' . $this->_channel_url . '",
                            status     : true,
                            cookie     : true,
                            xfbml      : true,
                            oauth      : true
                    });
                    AWD_facebook.FbEventHandler();
                };
            });';
        }
        $html .= '</script>';
        echo $html;
    }

    /**
     * Connect the user to wordpress.
     * Warning: use the method with care, as the user will be connected without password.
     * Be sure to check security by your self if you use it.
     * @param \WP_User
     */
    public function authenticateCookie($user)
    {
        wp_authenticate_cookie($user, '', '');
    }

    /**
     * Create a new WP user from facebook user
     * @return boolean
     */
    public function registerUser()
    {
        $username = sanitize_user($this->me['first_name'], true);
        $i = '';
        while (username_exists($username . $i)) {
            $i = absint($i);
            $i++;
        }
        $username = $username . $i;
        $userdata = array(
            'user_pass' => wp_generate_password(),
            'user_login' => $username,
            'user_nicename' => $username,
            'user_email' => $this->me['email'],
            'display_name' => $this->me['name'],
            'nickname' => $username,
            'first_name' => $this->me['first_name'],
            'last_name' => $this->me['last_name'],
            'role' => get_option('default_role'));

        $userdata = apply_filters('AWD_facebook_register_userdata', $userdata);

        $new_user = wp_insert_user($userdata);

        if (isset($new_user->errors)) {
            wp_die(print_r($new_user->errors, true));
        }

        //@TODO add an option to remove this email send.
        if (is_int($new_user)) {
            wp_new_user_notification($new_user, $userdata['user_pass']);

            return $new_user;
        }

        return false;
    }

    /**
     * Load the current user in memory, perform register if needed
     * @return boolean
     */
    public function getUserFromProvider()
    {
        if ($this->uid) {

            $facebookUserData = $this->getFacebookUserData($this->uid);
            $this->setMe($facebookUserData);

            if (is_wp_error($facebookUserData)) {
                return $facebookUserData;
            }

            //If user is already logged in and lauch a connect with facebook, try to change info about user account
            if (is_user_logged_in()) {
                $wpUserId = $this->getCurrentUser()->ID;
            } else {
                //Found existing user in WP
                $wpUserId = $this->getExistingUserFromFacebook();
            }

            return $wpUserId;
        }

        return false;
    }

    /**
     * Authenticate the current user using Facebook provider
     * @param  \WP_User $user
     * @param  string   $username
     * @param  string   $password
     * @return \WP_User
     */
    public function authenticate($user, $username = '', $password = '')
    {
        $wpUserId = $this->getUserFromProvider();

        //No user was found we create a new one
        if ($wpUserId == false && $this->uid) {
            $wpUserId = $this->registerUser();
        }
        if (is_wp_error($wpUserId)) {
            wp_die($wpUserId);
        } elseif (false === $wpUserId) {
            wp_redirect($this->_oauth_url);
            exit();
        }

        $this->updateFacebookUserData($wpUserId, $this->me);
        $this->initFacebookUserData($wpUserId);
        $user = new \WP_User($wpUserId);

        //Will create the cookie authentification of the user.
        $this->authenticateCookie($user);

        return $user;
    }

    /**
     * Filter logout url for users connected with Facebook
     * @param string
     * @return string
     */
    public function logoutUrl($url)
    {
        if ($this->isUserLoggedInFacebook()) {
            $parsing = parse_url($url);
            if (get_option('permalink_structure') != '')
                $redirectUrl = str_replace('action=logout&amp;', '', $this->_logout_url . '?' . $parsing['query']);
            else
                $redirectUrl = str_replace('action=logout&amp;', '', $this->_logout_url . '&' . $parsing['query']);

            $logoutUrl = $this->fcbk->getLogoutUrl(array(
                'access_token' => $this->fcbk->getAccessToken(),
                'next' => $redirectUrl . '/'));

            return $logoutUrl;
        }

        return $url;
    }

    /**
     * Logout a wordpress user after a Facebook logout
     * @param string
     */
    public function logout($redirectUrl = '')
    {
        $referer = wp_get_referer();
        $this->fcbk->destroySession();
        wp_logout();
        do_action('wp_logout');
        //if we are in an iframe or a canvas page, redirect to
        if (!empty($redirectUrl)) {
            wp_redirect($redirectUrl);
        } elseif (!empty($referer)) {
            wp_redirect($referer);
        } else {
            wp_redirect(home_url());
        }
        exit();
    }

    /**
     * Login a wordpress user after a facebook login
     * @param string $redirectUrl
     */
    public function login($redirectUrl = '')
    {
        //This filter will add the authentification process
        add_filter('authenticate', array(&$this, 'authenticate'), 10, 3);
        //This will call the filter
        $user = wp_signon('', is_ssl());
        $referer = wp_get_referer();
        //then redirect where we need.
        if (!empty($redirectUrl)) {
            wp_redirect($redirectUrl);
        } elseif (!empty($referer)) {
            wp_redirect($referer);
        } else {
            wp_redirect(home_url());
        }
        exit();
    }

    /**
     * Parse the query to handle the facebook entry point
     * @global \WP_Query $wp_query
     */
    public function parseQuery()
    {
        global $wp_query;
        $query = get_query_var('facebook_awd');
        $redirectUrl = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
        //Parse the query for internal process
        if (!empty($query)) {
            $action = $query['action'];
            switch ($action) {
                //LOGIN
                case 'login':
                    $this->login($redirectUrl);
                    break;

                //LOGOUT
                case 'logout':
                    $this->logout($redirectUrl);
                    break;

                //UNSYNC
                case 'unsync':
                    if ($this->isUserLoggedInFacebook()) {
                        $this->deleteFacebookUserData($this->getCurrentUser()->ID);
                        wp_redirect(wp_logout_url());
                    } else {
                        wp_redirect(wp_get_referer());
                    }
                    exit();
                    break;

                case 'channel.html':
                    $cacheExpire = 60 * 60 * 24 * 365;
                    header("Pragma: public");
                    header("Cache-Control: max-age=" . $cacheExpire);
                    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheExpire) . ' GMT');
                    echo '<script src="//connect.facebook.net/' . $this->options['locale'] . '/all.js"></script>';
                    exit();
                    break;

                case 'deauthorize':
                    $sr = $this->fcbk->getSignedRequest();
                    if (isset($sr['user_id'])) {
                        $wpUser = $this->getUserFromFbuid($sr['user_id']);
                        if ($wpUser) {
                            //require_once(ABSPATH.'wp-admin/includes/user.php');
                            //echo wp_delete_user($wpUser->ID);
                            //clean facebook user data
                            $this->deleteFacebookUserData($wpUser->ID);
                            exit();
                        }
                    }
                    wp_die($this->templateManager->displayMessage("Facebook AWD Deauthorize Error. Access denied", null, false));
                    break;
                case 'realtime-update-api':
                    $token = md5($this->options['app_id']);
                    //subscribe mode
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        if (!isset($_REQUEST['hub_mode']))
                            wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error hub_mode not set. Access denied", null, false));
                        if ($_REQUEST['hub_mode'] != 'subscribe')
                            wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error hub_mode not match current path. Access denied", null, false));
                        if (!isset($_REQUEST['hub_challenge']))
                            wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error hub_challenge not set. Access denied", null, false));
                        if (!isset($_REQUEST['hub_challenge']))
                            wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error hub_challenge not set. Access denied", null, false));
                        if (!isset($_REQUEST['hub_verify_token']))
                            wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error hub_verify_token not set. Access denied", null, false));
                        if ($_REQUEST['hub_verify_token'] != $token)
                            wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error hub_verify_token not match. Access denied", null, false));

                        echo $_REQUEST['hub_challenge'];
                        exit();
                    }
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $jsonResults = file_get_contents("php://input");
                        $shaToken = 'sha1=' . hash_hmac('sha1', $jsonResults, $this->options['app_secret_key']);

                        if ($_SERVER['HTTP_X_HUB_SIGNATURE'] == $shaToken) {
                            $updates = json_decode($jsonResults, true);

                            if ($updates['object'] == 'permissions') {
                                foreach ($updates['entry'] as $userChangeset) {
                                    $wpUser = $this->getUserFromFbuid($userChangeset['id']);
                                    $return = $this->getPermissions($userChangeset['id']);
                                    if (!is_wp_error($return)) {
                                        //update the perms of the user
                                        $oldFbData = $wpUser->fb_user_infos;
                                        if (is_array($oldFbData)) {
                                            //replace the old array of perms by the new one
                                            $newFbData = array_replace($oldFbData, array('permissions' => $return));
                                            $this->updateFacebookUserData($wpUser->ID, $newFbData);
                                        }
                                    } else {
                                        error_log("Facebook AWD " . print_r($return, true) . " error perms");
                                    }
                                }
                            }

                            if ($updates['object'] == 'user') {
                                foreach ($updates['entry'] as $userChangeset) {
                                    $wpUser = $this->getUserFromFbuid($userChangeset['id']);
                                    if ($wpUser) {
                                        $fbUser = $this->getFbUser($userChangeset['id']);
                                        if (!is_wp_error($fbUser)) {
                                            //update the user
                                            $oldFbData = $wpUser->fb_user_infos;
                                            if (is_array($fbUser)) {
                                                //replace the old array of perms by the new one
                                                $newFbData = array_replace($oldFbData, $fbUser);
                                                $this->updateFacebookUserData($wpUser->ID, $newFbData);
                                                wp_update_user(array(
                                                    'ID' => $wpUser->ID,
                                                    'user_nicename' => $newFbData['name'],
                                                    'display_name ' => $newFbData['name'],
                                                    'user_email' => $newFbData['email'],
                                                    'user_firstname' => $newFbData['first_name'],
                                                    'user_lastname' => $newFbData['last_name']));
                                            }
                                        } else {
                                            error_log("Facebook AWD " . print_r($return, true) . " error perms");
                                        }
                                    }
                                }
                            }
                            exit();
                        }
                    }
                    wp_die($this->templateManager->displayMessage("Facebook AWD Realtime Error. Access denied", null, false));
                    break;
            }
        }
    }

    /**
     * Flush the wp rewrite rules
     * @global \WP_Rewrite $wp_rewrite
     */
    public function flushRules()
    {
        $rules = get_option('rewrite_rules');
        if (!isset($rules['facebook-awd/(login|logout|unsync|channel.html|deauthorize|realtime-update-api)$'])) {
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }
    }

    /**
     * Insert the facebook rewrite rules into wp rules
     * @param  type $rules
     * @return type
     */
    public function insertRewriteRules($rules)
    {
        $newrules = array();
        $newrules['facebook-awd/(login|logout|unsync|channel.html|deauthorize|realtime-update-api)$'] = 'index.php?facebook_awd[action]=$matches[1]';

        return $newrules + $rules;
    }

    /**
     * Insert plugin query vars
     * @param  array  $vars
     * @return string
     */
    public function insertQueryVars($vars)
    {
        $vars[] = 'facebook_awd';

        return $vars;
    }

    /**
     * Print the login button on the wp-login.php page
     */
    public function loginbuttonOnWpLogin()
    {
        echo do_shotcode(['AWD_facebook_loginbutton']);
    }

    /**
     * Add manager to post editor
     * @param \WP_Post object
     */
    public function postManagerContent($post)
    {
        //Prepare manager for link publish or post.
        $id = $post->ID;
        $url = get_permalink($post->ID);
        $custom = get_post_meta($id, self::PLUGIN_SLUG, true);
        $options = array();
        if (isset($custom)) {
            $options = $custom;
        }
        $options = wp_parse_args($options, $this->options['content_manager']);
        $form = new AWD_facebook_form('form_posts_settings', 'POST', '', self::OPTION_PREFIX);
        echo '
            <div class="AWD_facebook_wrap">
                ' . do_action('AWD_facebook_admin_notices') . '
                <h2>' . __('Like Button', self::PTD) . '</h2>';

        if ($url != '') {
            echo '
                    <div class="alert alert-info">
                        ' . do_shortcode('[AWD_facebook_likebutton width="250" href="' . $url . '"]');
            if (isset($this->plugins["awd_fcbk_post_to_feed"]))
                echo do_shortcode('[AWD_facebook_post_to_feed_button width="250" href="' . $url . '"]');
            echo '
                    </div>';
        }

        echo '
                    <div class="row">';
        echo $form->addSelect(__('Redefine globals settings ?', self::PTD), 'likebutton[redefine]', array(
            array(
                'value' => 0,
                'label' => __('No', self::PTD)
            ),
            array(
                'value' => 1,
                'label' => __('Yes', self::PTD)
            )), $options['likebutton']['redefine'], 'span3', array(
            'class' => 'span3'
                )
        );


        echo $form->addSelect(__('Activate ?', self::PTD), 'likebutton[enabled]', array(
            array(
                'value' => 0,
                'label' => __('No', self::PTD)),
            array(
                'value' => 1,
                'label' => __('Yes', self::PTD)
            )
                ), $options['likebutton']['enabled'], 'span3', array(
            'class' => 'span3'
                )
        );

        echo $form->addSelect(__('Where ?', self::PTD), 'likebutton[place]', array(
            array(
                'value' => 'top',
                'label' => __('Top', self::PTD)
            ),
            array(
                'value' => 'bottom',
                'label' => __('Bottom', self::PTD)
            ),
            array(
                'value' => 'both',
                'label' => __('Both', self::PTD)
            )), $options['likebutton']['place'], 'span3', array(
            'class' => 'span3'
                )
        );
        echo '
                </div>';

        if (current_user_can('manage_facebook_awd_publish_to_pages')) {
            echo '<h2>' . __('Publish to Facebook', self::PTD) . '</h2>';
            if ($this->isUserLoggedInFacebook()) {
                if ($this->currentFacebookUserCan('publish_stream')) {
                    if ($this->currentFacebookUserCan('manage_pages')) {
                        echo '
                        <div class="row">';

                        echo $form->addSelect(__('Publish to pages ?', self::PTD), 'fbpublish[to_pages]', array(
                            array(
                                'value' => 0,
                                'label' => __('No', self::PTD)
                            ),
                            array(
                                'value' => 1,
                                'label' => __('Yes', self::PTD)
                            )), $options['fbpublish']['to_pages'], 'span3', array(
                            'class' => 'span3'
                                )
                        );

                        echo $form->addSelect(__('Publish to profile ?', self::PTD), 'fbpublish[to_profile]', array(
                            array(
                                'value' => 0,
                                'label' => __('No', self::PTD)
                            ),
                            array(
                                'value' => 1,
                                'label' => __('Yes', self::PTD)
                            )), $options['fbpublish']['to_profile'], 'span3', array(
                            'class' => 'span3'
                                )
                        );

                        echo $form->addInputText(__('Custom Action Label', self::PTD), 'fbpublish[read_more_text]', $options['fbpublish']['read_more_text'], 'span3', array(
                            'class' => 'span3'
                        ));

                        echo $form->addInputTextArea(__('Add a message to the post ?', self::PTD), 'fbpublish[message_text]', $options['fbpublish']['message_text'], 'span3', array(
                            'class' => 'span3'
                        ));


                        echo '
                        </div>';
                    } else {
                        $this->addWarnings(new \WP_Error('AWD_facebook_pages_auth', __('You must authorize manage_pages permission in the settings of the plugin', self::PTD)));
                        $this->templateManager->displayNotices();
                    }
                } else {
                    $this->addWarnings(new \WP_Error('AWD_facebook_pages_auth_publish_stream', __('You must authorize publish_stream permission in the settings of the plugin', self::PTD)));
                    $this->templateManager->displayNotices();
                }
            } else {
                echo '<p>' . do_shortcode('[AWD_loginbutton]') . '</p>';
            }
        }

        if (current_user_can('manage_facebook_awd_opengraph')) {
            if ($this->options['open_graph_enable'] == 1) {
                echo '<h2>' . __('Opengraph', self::PTD) . '</h2>';
                $addLink = '<a class="btn btn btn-mini" href="' . admin_url('admin.php?page=' . self::PLUGIN_SLUG . '_open_graph') . '" target="_blank"><i class="icon-plus"></i> ' . __('Create an object', self::PTD) . '</a>';
                $ogpObjects = apply_filters('AWD_facebook_ogp_objects', $this->options['opengraph_objects']);
                if (is_array($ogpObjects) && count($ogpObjects)) {
                    $selectObjectsOptions = array(
                        array(
                            'value' => '',
                            'label' => __('Default', self::PTD)),
                        array(
                            'value' => 'custom',
                            'label' => __('Custom', self::PTD))
                    );
                    foreach ($ogpObjects as $key => $ogp_object) {
                        $selectObjectsOptions[] = array(
                            'value' => $key,
                            'label' => $ogp_object['object_title']
                        );
                    }
                    echo '<div class="row">';
                    echo $form->addSelect(__('Redefine Opengraph object for this post', self::PTD), 'opengraph[object_link]', $selectObjectsOptions, $options['opengraph']['object_link'], 'span3', array(
                        'class' => 'span3'
                    )) . $addLink;
                    echo '</div>';
                } else {
                    $this->templateManager->displayMessage(sprintf(__('No Object found.', self::PTD) . ' ' . $addLink, '<a href="' . admin_url('admin.php?page=' . self::PLUGIN_SLUG . '_open_graph') . '" target="_blank">', '</a>'), 'warning');
                }

                $opengraphArray = isset($options['awd_ogp']) ? $options['awd_ogp'] : null;

                echo '<div class="hidden opengraph_object_form">';
                $this->getOpengraphObjectForm($opengraphArray);
                echo '</div>';
            }
        }

        echo '</div>';
    }

    //****************************************************************************************
    //	COMMENTS FORM
    //****************************************************************************************

    /**
     * Display the comment form on posts/pages
     */
    public function displayTheCommentForm()
    {
        global $post;
        echo do_shortcode('[AWD_facebook_commentsbox href="' . get_permalink($post->ID) . '"]');
    }

    /**
     * Replace the default comments form
     * @global \WP_Post $post
     * @param  string $commentsTemplatePath
     * @return string
     */
    public function theCommentsForm($commentsTemplatePath)
    {
        global $post;
        $excludePostPageId = explode(",", $this->options['commentsbox']['exclude_post_id']);
        $commentsTemplatePath = '';
        if (!in_array($post->ID, $excludePostPageId)) {
            $activated = false;
            if (
                    ($post->post_type == 'page' && $this->options['commentsbox']['on_pages']) ||
                    ($post->post_type == 'post' && $this->options['commentsbox']['on_posts']) ||
                    (in_array($post->post_type, get_post_types(array('public' => true, '_builtin' => false))) && $this->options['commentsbox']['on_custom_post_types'])
            ) {
                $activated = true;
            }
            if ($activated) {
                if ($this->options['commentsbox']['place'] == 'replace') {
                    //replace the form with a template.
                    $commentsTemplatePath = $this->options['commentsbox']['comments_template_path'];
                } else {
                    add_action('comment_form_' . $this->options['commentsbox']['place'], array(&$this, 'displayTheCommentForm'));
                }
            }
        }

        return $commentsTemplatePath;
    }

    //****************************************************************************************
    //	REGISTER WIDGET
    //****************************************************************************************

    /**
     * Register the  Wordpress widgets
     * @global \WP_Widget_Factory $wp_widget_factory
     */
    public function register_AWD_facebook_widgets()
    {
        global $wp_widget_factory;

        require(dirname(__FILE__) . '/inc/admin/forms/likebox.php');
        $wp_widget_factory->widgets['AWD_facebook_widget_likebox'] = new AWD_facebook_widget(array(
            'id_base' => 'likebox',
            'name' => self::PLUGIN_NAME . ' ' . __('Like Box', self::PTD),
            'description' => __('Add a Facebook Like Box', self::PTD),
            'model' => $fields['likebox'],
            'self_callback' => array(
                $this->templateManager,
                'renderPlugin'
            ),
            'preview' => true
        ));

        require(dirname(__FILE__) . '/inc/admin/forms/likebutton.php');
        $wp_widget_factory->widgets['AWD_facebook_widget_likebutton'] = new AWD_facebook_widget(array(
            'id_base' => 'likebutton',
            'name' => self::PLUGIN_NAME . ' ' . __('Like Button', self::PTD),
            'description' => __('Add a Facebook Like Button', self::PTD),
            'model' => $fields['likebutton'],
            'self_callback' => array(
                $this->templateManager,
                'renderPlugin'
            ),
            'preview' => true
        ));

        require(dirname(__FILE__) . '/inc/admin/forms/loginbutton.php');
        $wp_widget_factory->widgets['AWD_facebook_widget_loginbutton'] = new AWD_facebook_widget(array(
            'id_base' => 'loginbutton',
            'name' => self::PLUGIN_NAME . ' ' . __('Login Button', self::PTD),
            'description' => __('Add a Facebook Login Button', self::PTD),
            'model' => $fields['loginbutton'],
            'self_callback' => array(
                $this->templateManager,
                'renderPlugin'
            )
        ));

        require(dirname(__FILE__) . '/inc/admin/forms/activitybox.php');
        $wp_widget_factory->widgets['AWD_facebook_widget_activitybox'] = new AWD_facebook_widget(array(
            'id_base' => 'activitybox',
            'name' => self::PLUGIN_NAME . ' ' . __('Activity Box', self::PTD),
            'description' => __('Add a Facebook Activity Box', self::PTD),
            'model' => $fields['activitybox'],
            'self_callback' => array(
                $this->templateManager,
                'renderPlugin'
            ),
            'preview' => true
        ));

        require(dirname(__FILE__) . '/inc/admin/forms/commentsbox.php');
        $wp_widget_factory->widgets['AWD_facebook_widget_commentsbox'] = new AWD_facebook_widget(array(
            'id_base' => 'commentsbox',
            'name' => self::PLUGIN_NAME . ' ' . __('Comments Box', self::PTD),
            'description' => __('Add a Facebook Comments Box', self::PTD),
            'model' => $fields['commentsbox'],
            'self_callback' => array(
                $this->templateManager,
                'renderPlugin'
            )
        ));

        require(dirname(__FILE__) . '/inc/admin/forms/shared_activitybox.php');
        $wp_widget_factory->widgets['AWD_facebook_widget_shared_activitybox'] = new AWD_facebook_widget(array(
            'id_base' => 'shared_activitybox',
            'name' => self::PLUGIN_NAME . ' ' . __('Shared Activity Box', self::PTD),
            'description' => __('Add a Facebook Shared Activity Box', self::PTD),
            'model' => $fields['shared_activitybox'],
            'self_callback' => array(
                $this->templateManager,
                'renderPlugin'
            )
        ));
    }

    //****************************************************************************************
    //	Setter AND Getter
    //****************************************************************************************

    /**
     * Return the admin menu hook
     * @return string
     */
    public function getAdminMenuHook()
    {
        return $this->adminMenuHook;
    }

    /**
     * Set the admin menu hook
     * @param string
     */
    public function setAdminMenuHook($adminMenuHook)
    {
        $this->adminMenuHook = $adminMenuHook;
    }

    /**
     * Return the plugins menu hook
     * @return string
     */
    public function getPluginsMenuHook()
    {
        return $this->pluginsMenuHook;
    }

    /**
     * Set the plugins menu hook
     * @param string
     */
    public function setPluginsMenuHook($pluginsMenuHook)
    {
        $this->pluginsMenuHook = $pluginsMenuHook;
    }

    /**
     * Return the opengraph menu hook
     * @return string
     */
    public function getOpengraphMenuHook()
    {
        return $this->opengraphMenuHook;
    }

    /**
     * Set the opengraph menu hook
     * @param string
     */
    public function setOpengraphMenuHook($opengraphMenuHook)
    {
        $this->opengraphMenuHook = $opengraphMenuHook;
    }

    /**
     * Get the options of the plugin
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options of the plugin
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Return the option Manager
     * @return AWD_facebook_options
     */
    public function getOptionsManager()
    {
        return $this->optionsManager;
    }

    /**
     * Set the option Manager
     * @param AWD_facebook_options $optionsManager
     */
    public function setOptionsManager($optionsManager)
    {
        $this->optionsManager = $optionsManager;
    }

    /**
     * Return the template Manager
     * @return AWD_facebook_template
     */
    public function getTemplatesManager()
    {
        return $this->templatesManager;
    }

    /**
     * Set the template Manager
     * @param AWD_facebook_template $templatesManager
     */
    public function setTemplatesManager($templatesManager)
    {
        $this->templatesManager = $templatesManager;
    }

    /**
     * Get the plugins of Facebook AWD
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Set the plugin of Facebook AWD
     * @param array $plugins
     */
    public function setPlugins(array $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * Add a plugin on Facebook AWD
     * @param AWD_facebook_plugin_interface $plugin
     */
    public function addPlugin(AWD_facebook_plugin_interface $plugin)
    {
        $this->plugins[$plugin::PLUGIN_SLUG] = $plugin;
    }

    /**
     * Get all dependencies path of the plugin
     * @return array
     */
    public function getDependencies()
    {
        return apply_filters("AWD_facebook_dependencies", $this->dependencies);
    }

    /**
     * Set all dependencies path
     * @param array $dependencies
     */
    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * Add a dependency path
     * @param string              $name
     * @param string|array|object $value
     */
    public function addDependency($name, $value)
    {
        $this->dependencies[$name] = $value;
    }

    /**
     * Get the AWD_facebook_api instance
     * @return AWD_facebook_api
     */
    public function getFcbk()
    {
        return $this->fcbk;
    }

    /**
     * Set the AWD_facebook_api instance
     * @param AWD_facebook_api $fcbk
     */
    public function setFcbk($fcbk)
    {
        $this->fcbk = $fcbk;
    }

    /**
     * Return the current facebook user id
     * @return integer
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the current facebook user id
     * @param integer $uid
     */
    public function setUid($uid)
    {
        $this->uid = absint($uid);
    }

    /**
     * Return the current facebook user infos
     * @return array
     */
    public function getMe()
    {
        return $this->me;
    }

    /**
     * Set the current facebook user infos
     * @param array $me
     */
    public function setMe(array $me)
    {
        $this->me = $me;
    }

    /**
     * Return the authentication Entry point Url of the plugin
     * After an authentication on facebook, the user should be redirected to this url
     * to process the facebook authentication
     * @return string
     */
    public function getAuthenthicationEntryPointUrl()
    {
        return $this->authenthicationEntryPointUrl;
    }

    /**
     * Set the authentication Entry point Url of the plugin
     * @param string $authenthicationEntryPointUrl
     */
    public function setAuthenthicationEntryPointUrl($authenthicationEntryPointUrl)
    {
        $this->authenthicationEntryPointUrl = $authenthicationEntryPointUrl;
    }

    /**
     * Return the logout url handler of the plugin
     * After a facebook logout, the user should be redirect on this url
     * to process the wordpress logout.
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->logoutUrl;
    }

    /**
     * Set the logout url handler of the plugin
     * @param string $logoutUrl
     */
    public function setLogoutUrl($logoutUrl)
    {
        $this->logoutUrl = $logoutUrl;
    }

    /**
     * Return the unsync url handler of the plugin
     * If the user want to clean all their facebook datas, redirect him on this url.
     * @return string
     */
    public function getUnsyncUrl()
    {
        return $this->unsyncUrl;
    }

    /**
     * Set the unsync url handler of the plugin
     * @param string $unsyncUrl
     */
    public function setUnsyncUrl($unsyncUrl)
    {
        $this->unsyncUrl = $unsyncUrl;
    }

    /**
     * Get the facebook authentication url
     * @return string
     */
    public function getOauthUrl()
    {
        return $this->oauthUrl;
    }

    /**
     * Set the facebook authentication url
     * @param string $oauthUrl
     */
    public function setOauthUrl($oauthUrl)
    {
        $this->oauthUrl = $oauthUrl;
    }

}
