<?php

require_once(dirname(__FILE__) . '/class.AWD_facebook_plugin_interface.php');

/**
 *
 * @author alexhermann
 *
 */
abstract class AWD_facebook_plugin_abstract implements AWD_facebook_plugin_interface
{
    /**
     * The plugin Slug
     */
    const PLUGIN_SLUG = 'awd_plugin_exemple';

    /**
     * The plugin name
     */
    const PLUGIN_NAME = 'Configure me';

    /**
     * The plugin text domain
     */
    const PTD = 'AWD_facebook_plugin_exemple';

    /**
     * The min version required of Facebook AWD
     */
    const MIN_VERSION = 1.4;

    /**
     * The file related to the plugin
     * @var string
     */
    protected $file;

    /**
     * The Admin Menu Hook
     * @var string
     */
    protected $adminMenuHook = null;

    /**
     * The dependencies of the plugin
     * @var array
     */
    protected static $requires = array('connect' => 0);

    /**
     * The instance of Facebook AWD
     * @var AWD_facebook
     */
    public $AWD_facebook;

    /**
     * The plugin url
     * @var string
     */
    public $pluginUrl;

    /**
     * The plugin images url
     * @var string
     */
    public $pluginImagesUrl;

    /**
     *
     * @param string $file
     * @param type $AWD_facebook
     */
    public function __construct($file, $AWD_facebook)
    {
        $this->file = $file;
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (is_plugin_inactive('facebook-awd/AWD_facebook.php')) {
            add_action('AWD_facebook_admin_notices', array(&$this, 'missingParent'));
            deactivate_plugins($this->file);
        } elseif ($AWD_facebook->getVersion() < self::MIN_VERSION) {
            add_action('AWD_facebook_admin_notices', array(&$this, 'oldParent'));
            deactivate_plugins($this->file);
        } else {
            add_action('AWD_facebook_plugins_init', array(&$this, 'initialisation'));
            add_action('AWD_facebook_save_custom_settings', array(&$this, 'handlePostUpdate'));
            add_action('AWD_facebook_register_widgets', array(&$this, 'registerWidgets'));
        }
        $this->AWD_facebook = $AWD_facebook;
    }

    /**
     * This method must be declared in the child class as init
     */
    abstract function initialisation();

    /**
     * The init of the plugin
     * This method must be calld in the initialisation(); abstract method.
     */
    public function init()
    {
        $options = $this->AWD_facebook->getOptions();

        $this->pluginUrl = WP_PLUGIN_URL . DIRECTORY_SEPARATOR . basename(dirname($this->file));
        $this->pluginImagesUrl = $this->pluginUrl . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;

        load_plugin_textdomain(self::PTD, false, dirname(plugin_basename($this->file)) . DIRECTORY_SEPARATOR . 'langs' . DIRECTORY_SEPARATOR);

        if ($options['connect_enable'] != 1 && self::$requires['connect'] == 1) {

            add_action('AWD_facebook_admin_notices', array(&$this, 'missingFacebookConnect'));
            deactivate_plugins($this->file);

        } else {

            add_action('AWD_facebook_admin_menu', array(&$this, 'adminMenu'));
            //to enqueue style only on front end
            add_action('wp_enqueue_scripts', array(&$this, 'frontEnqueueJs'));
            add_action('wp_enqueue_scripts', array(&$this, 'frontEnqueueCss'));
            //to enqueue global scripts everywhere
            add_action('admin_print_scripts', array(&$this, 'globalEnqueueJs'));
            add_action('admin_print_style', array(&$this, 'globalEnqueueCss'));
            add_action('wp_enqueue_scripts', array(&$this, 'globalEnqueueJs'));
            add_action('wp_enqueue_styles', array(&$this, 'globalEnqueueCss'));

            add_filter('AWD_facebook_jsVars', array($this, 'jsVars'));
            //Add action to create custom menu and custom form in plugin
            add_filter('AWD_facebook_plugins_menu', array(&$this, 'pluginSettingsMenu'), 10, 1);
            add_filter('AWD_facebook_plugins_form', array(&$this, 'pluginSettingsForm'), 10, 1);

        }

        add_filter('AWD_facebook_options', array($this, 'defaultOptions'));

        $this->AWD_facebook->addPlugin($this);
    }

    /**
     * Regiter options of the plugin
     *
     * @param array $options
     * @return array
     */
    public function defaultOptions($options)
    {
        return $options;
    }

    /**
     * Get the version of the plugin
     * @return strgin
     */
    public function getVersion()
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $plugin_folder = get_plugins();
        return $plugin_folder[basename(dirname($this->file)) . DIRECTORY_SEPARATOR . str_replace('class.', '', basename($this->file))]['Version'];
    }

    /**
     * Display error if facebook connect is not activated
     */
    public function missingFacebookConnect()
    {
        $this->AWD_facebook->templateManager->displayMessage(self::PLUGIN_NAME . ' ' . __("can not be activated: Facebook Connect plugin must be activated", self::PTD), 'error');
    }

    /**
     * Display error if Facebook AWD plugin is too old
     */
    public function oldParent()
    {
        $this->AWD_facebook->templateManager->displayMessage(self::PLUGIN_NAME . ' ' . __("can not be activated: Facebook AWD is out to date... You can download the last version or update it from the Wordpress plugin directory", self::PTD), 'error');
    }

    /**
     * Display error if Facebook AWD is not installed
     */
    public function missingParent()
    {
        $this->AWD_facebook->templateManager->displayMessage(self::PLUGIN_NAME . ' ' . __("can not be activated: Facebook AWD plugin must be installed... you can download it from the Wordpress plugin directory", self::PTD), 'error');
    }

    /**
     * Init of the admin of the plugin
     */
    public function adminInit()
    {
        add_screen_option('layout_columns', array('max' => 2, 'default' => 2));
    }

    /**
     * Init of the admin menu of the plugin
     */
    public function adminMenu()
    {
        //Load the js lib AWD
        if ($this->getAdminMenuHook() !== null) {
            add_action('load-' . $this->getAdminMenuHook(), array(&$this, 'adminInit'));
            add_action('admin_print_styles-' . $this->getAdminMenuHook(), array(&$this->AWD_facebook, 'adminEnqueueCss'));
            add_action('admin_print_styles-' . $this->getAdminMenuHook(), array(&$this, 'adminEnqueueCss'));
            add_action('admin_print_scripts-' . $this->getAdminMenuHook(), array(&$this->AWD_facebook, 'adminEnqueueJs'));
            add_action('admin_print_scripts-' . $this->getAdminMenuHook(), array(&$this, 'adminEnqueueJs'));
        }
    }

    /**
     * Filter to add items in  the plugins menu list of admin
     * @param array $list
     * @return array
     */
    public function pluginSettingsMenu($list)
    {
        return $list;
    }

    /**
     * Filter to add items in the plugins form section
     * note: the tab of the section must be initilized using the menu filter. (methods: pluginSettingsMenu())
     *
     * @param array $fields
     * @return array
     */
    public function pluginSettingsForm($fields)
    {
        return $fields;
    }

    public function jsVars($vars)
    {
        //$vars['FBEventHandler']['callbacks'][self::PLUGIN_SLUG][] = 'nameOfcallbackinitFunction';
        return $vars;
    }

    /**
     * Method to handle post data when a post is updated
     */
    public function handlePostUpdate()
    {

    }

    /**
     * Display the admin form in plugin area if dedicated page was create.
     */
    public function adminForm()
    {

    }

    /**
     * Enqueue javascript of the plugin on all pages
     */
    public function globalEnqueueJs()
    {

    }

    /**
     * Enqueue css styles of the plugin on all pages
     */
    public function globalEnqueueCss()
    {

    }

    /**
     * Enqueue public javascript of the plugin
     */
    public function frontEnqueueJs()
    {

    }

    /**
     * Enqueue public css styles of the plugin
     */
    public function frontEnqueueCss()
    {

    }

    /**
     * Enqueue admin javascript of the plugin
     */
    public function adminEnqueueJs()
    {

    }

    /**
     * Enqueue admin css styles of the plugin
     */
    public function adminEnqueueCss()
    {

    }

    /**
     * Register the widget
     */
    public function registerWidgets()
    {

    }

    /**
     * Get the menu hook
     * @return string
     */
    public function getAdminMenuHook()
    {
        return $this->adminMenuHook;
    }

    /**
     * Set the menu Hook
     * @param string
     */
    public function setAdminMenuHook($adminMenuHook)
    {
        $this->adminMenuHook = $adminMenuHook;
    }


}