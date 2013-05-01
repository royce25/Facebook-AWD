<?php

/**
 *
 * @author alexhermann
 *
 */
//NEEDED VARS
global $wpdb;
$this->wpdb = $wpdb;

$this->pluginUrl = WP_PLUGIN_URL . DIRECTORY_SEPARATOR . basename(dirname(dirname(__FILE__)));
$this->pluginImagesUrl = $this->pluginUrl . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;

//TRANSLATION
load_plugin_textdomain(self::PTD, false, dirname(__FILE__) . DIRECTORY_SEPARATOR . 'langs' . DIRECTORY_SEPARATOR);

//init
$this->set_admin_roles();
add_action("init", array(&$this, 'wpInit'));
add_action('admin_init', array(&$this, 'adminInitialisation'));

//DISPLAY ADMIN
add_action('admin_bar_init', array(&$this, 'adminBarInit'));
add_action('AWD_facebook_admin_settings_check', array(&$this, 'missingConfig'));
add_action('admin_menu', array(&$this, 'adminMenu'));
add_action('network_admin_menu', array(&$this, 'loadJs'));
add_filter("admin_footer_text", array($this, 'adminFooterText'), 10, 1);

//DISPLAY FRONT
add_filter('language_attributes', array($this, 'ogp_language_attributes'), 10, 1);
add_action('after_setup_theme', array(&$this, 'addThemeSupport'));
add_action('wp_head', array(&$this, 'display_ogp_objects'));
add_filter('the_content', array(&$this, 'the_content'));
add_filter('comments_template', array(&$this, 'the_comments_form'));
add_action('wp_enqueue_scripts', array(&$this, 'frontEnqueueJs'));

//INTERNAL
add_action('wp_ajax_get_media_field', array(&$this, 'ajax_get_media_field'));
add_action('wp_ajax_get_app_infos_content', array(&$this, 'get_app_infos_content'));
add_action('wp_ajax_delete_ogp_object', array(&$this, 'delete_ogp_object'));
add_action('wp_ajax_save_ogp_object', array(&$this, 'save_ogp_object'));
add_action('wp_ajax_save_ogp_object_links', array(&$this, 'save_ogp_object_links'));
add_action('wp_ajax_get_open_graph_object_form', array(&$this, 'ajax_get_open_graph_object_form'));
add_filter('rewrite_rules_array', array(&$this, 'insert_rewrite_rules'));
add_filter('query_vars', array(&$this, 'insert_query_vars'));
add_action('wp_loaded', array(&$this, 'flush_rules'));
add_action('parse_query', array(&$this, 'parse_request'));
add_filter('logout_url', array(&$this, 'logout_url'));
add_action('save_post', array(&$this, 'handlePostUpdate'));
add_action('edit_user_profile', array(&$this, 'user_profile_edit'));
add_action('show_user_profile', array(&$this, 'user_profile_edit'));
add_action('personal_options_update', array(&$this, 'user_profile_save'));
add_action('edit_user_profile_update', array(&$this, 'user_profile_save'));
add_action("AWD_facebook_save_settings", array(&$this, 'hook_post_from_plugin_options'));
add_action("wp_ajax_awd_fcbk_save_settings", array(&$this, 'ajax_hook_post_from_plugin_options'));

//remove frame security header to allow the website admin to work in iframe
remove_action('login_init', 'send_frame_options_header');
remove_action('adminInit', 'send_frame_options_header');

//OPTIONS
$this->optionsManager = new AWD_facebook_options(self::OPTION_PREFIX, $this->wpdb);
$this->optionsManager->load();
$this->options = $this->optionsManager->getOptions();

//Tools
$this->templateManager = new AWD_facebook_template($this);
$shortcodeCallback = array($this->templateManager, 'renderShortcode');
add_shortcode('AWD_facebook_likebutton', $shortcodeCallback);
add_shortcode('AWD_facebook_likebox', $shortcodeCallback);
add_shortcode('AWD_facebook_activitybox', $shortcodeCallback);
add_shortcode('AWD_facebook_shared_activitybox', $shortcodeCallback);
add_shortcode('AWD_facebook_loginbutton', $shortcodeCallback);
add_shortcode('AWD_facebook_commentsbox', $shortcodeCallback);




//Init the SDK PHP
if (!empty($this->options['app_id']) && !empty($this->options['app_secret_key'])) {
    $this->php_sdk_init();
}
//load the facebook lib
//and load the sdk if connect if activated.
add_action('wp_print_footer_scripts', array(&$this, 'js_sdk_init'), 11);
add_action('admin_print_footer_scripts', array(&$this, 'js_sdk_init'));


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

        //add action to add the login button on the wp-login.php page...
        if ($on_register == 1 || $on_login == 1) {
            add_action('login_enqueue_scripts', array(&$this, 'login_enqueue_scripts'));
        }
        if ($on_login == 1) {
            add_action('login_form', array(&$this, 'the_loginbutton_wp_login'));
        }
        if ($on_register == 1) {
            add_action('register_form', array(&$this, 'the_loginbutton_wp_login'));
        }
        //Add avatar functions
        if ($this->options['connect_fbavatar'] == 1) {
            add_filter('get_avatar', array($this, 'fb_get_avatar'), 100, 5); //modify in last...
        }
    }
}
?>