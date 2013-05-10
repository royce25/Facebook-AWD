<?php

/**
 * Init include
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */

global $wpdb;
$this->wpdb = $wpdb;

$this->pluginUrl = WP_PLUGIN_URL . DIRECTORY_SEPARATOR . basename(dirname(dirname(__FILE__)));
$this->pluginImagesUrl = $this->pluginUrl . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;

//TRANSLATION
load_plugin_textdomain(self::PTD, false, dirname(__FILE__) . DIRECTORY_SEPARATOR . 'langs' . DIRECTORY_SEPARATOR);

//init
$this->setAdminRoles();
add_action("init", array(&$this, 'wpInit'));
add_action('admin_init', array(&$this, 'adminInitialisation'));

//DISPLAY ADMIN

//add_action('AWD_facebook_admin_settings_check', array(&$this, 'missingConfig'));
//add_action('admin_bar_init', array(&$this, 'adminBarInit'));
//add_action('admin_menu', array(&$this, 'adminMenu'));
//add_filter("admin_footer_text", array($this, 'adminFooterText'), 10, 1);


//DISPLAY FRONT
//add_filter('language_attributes', array($this, 'ogpLanguageAttributes'), 10, 1);
//@TODO check this input, as the init is already existing at this time.
//add_action('after_setup_theme', array(&$this, 'addThemeSupport'));
//add_action('wp_head', array(&$this, 'displayOgpObjects'));
//add_filter('the_content', array(&$this, 'filterContent'));
//add_filter('comments_template', array(&$this, 'theCommentsForm'));
//add_action('wp_enqueue_scripts', array(&$this, 'frontEnqueueJs'));

//INTERNAL
//add_action('wp_ajax_get_media_field', array(&$this, 'ajaxGetMediaField'));
//add_action('wp_ajax_get_app_infos_content', array(&$this, 'getAppInfosContent'));
//add_action('wp_ajax_delete_ogp_object', array(&$this, 'deleteOgpObject'));
//add_action('wp_ajax_save_ogp_object', array(&$this, 'saveOgpObject'));
//add_action('wp_ajax_save_ogp_object_links', array(&$this, 'saveOgpObjectLinks'));
//add_action('wp_ajax_get_opengraph_object_form', array(&$this, 'ajaxGetOpengraphObjectForm'));
//add_filter('rewrite_rules_array', array(&$this, 'insertRewriteRules'));
//add_filter('query_vars', array(&$this, 'insertQueryVars'));
//add_action('wp_loaded', array(&$this, 'flushRules'));
//add_action('parse_query', array(&$this, 'parseQuery'));
//add_filter('logout_url', array(&$this, 'logoutUrl'));
//add_action('save_post', array(&$this, 'handlePostUpdate'));
//add_action('edit_user_profile', array(&$this, 'userProfileEdit'));
//add_action('show_user_profile', array(&$this, 'userProfileEdit'));
//add_action('personal_options_update', array(&$this, 'handleUserProfileUpdate'));
//add_action('edit_user_profile_update', array(&$this, 'handleUserProfileUpdate'));
//add_action("AWD_facebook_save_settings", array(&$this, 'handleSettingsUpdate'));
//add_action("wp_ajax_awd_fcbk_save_settings", array(&$this, 'ajaxHandleSettingsUpdate'));

//remove frame security header to allow the website admin to work in iframe
//remove_action('login_init', 'send_frame_options_header');
//remove_action('adminInit', 'send_frame_options_header');

//OPTIONS
//$this->optionsManager = new OptionManager(self::OPTION_PREFIX, $this->wpdb);
//$this->optionsManager->load();
//$this->options = $this->optionsManager->getOptions();

//Tools
/*$this->templateManager = new TemplateManager($this);
$shortcodeCallback = array($this->templateManager, 'renderShortcode');
add_shortcode('AWD_facebook_likebutton', $shortcodeCallback);
add_shortcode('AWD_facebook_likebox', $shortcodeCallback);
add_shortcode('AWD_facebook_activitybox', $shortcodeCallback);
add_shortcode('AWD_facebook_shared_activitybox', $shortcodeCallback);
add_shortcode('AWD_facebook_loginbutton', $shortcodeCallback);
add_shortcode('AWD_facebook_commentsbox', $shortcodeCallback);




//Init the SDK PHP
if (!empty($this->options['app_id']) && !empty($this->options['app_secret_key'])) {
    $this->initFacebookPhpSdk();
}
//load the facebook lib
//and load the sdk if connect if activated.
add_action('wp_print_footer_scripts', array(&$this, 'initFacebookJavascriptSDK'), 11);
add_action('admin_print_footer_scripts', array(&$this, 'initFacebookJavascriptSDK'));


//UPDATES OPTIONS
do_action("AWD_facebook_save_settings");
do_action("AWD_facebook_plugins_init");
do_action("AWD_facebook_save_settings");

$this->optionsManager->load();
$this->options = $this->optionsManager->getOptions();

//check settings
do_action('AWD_facebook_admin_settings_check');
add_action('AWD_facebook_admin_notices', array(&$this->templateManager, 'displayNotices'), 10, 1);


//init the FB connect
if ($this->options['app_id'] != '' && $this->options['app_secret_key'] != '') {
    if ($this->options['connect_enable'] == 1) {
        $on_register = $this->options['loginbutton']['display_on_register_page'];
        $on_login = $this->options['loginbutton']['display_on_login_page'];

        add_action('login_enqueue_scripts', array(&$this, 'loadJs'));
        add_action('network_admin_menu', array(&$this, 'loadJs'));

        if ($on_login == 1) {
            add_action('login_form', array(&$this, 'loginbuttonOnWpLogin'));
        }
        if ($on_register == 1) {
            add_action('register_form', array(&$this, 'loginbuttonOnWpLogin'));
        }
        //Add avatar functions
        if ($this->options['connect_fbavatar'] == 1) {
            add_filter('get_avatar', array($this, 'getFacebookAvatar'), 100, 5); //modify in last...
        }
    }
}*/
?>