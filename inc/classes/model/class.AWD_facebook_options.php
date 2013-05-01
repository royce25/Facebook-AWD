<?php

/**
 *
 * @author alexhermann
 *
 */
class AWD_facebook_options
{

    /**
     *
     * @var array
     */
    protected $options = array();

    /**
     *
     * @var WPDB object
     */
    protected $wpdb;

    /**
     *
     * @var string
     */
    protected $prefix;

    /**
     *
     * @var string
     */
    protected $filterName = "AWD_facebook_options";

    /**
     *
     * @param string $prefix
     * @param WPDB Object $wpdb
     */
    public function __construct($prefix, $wpdb)
    {
        $this->wpdb = $wpdb;
        $this->prefix = $prefix;
        //call filter for undefined vars
        add_filter($this->filterName, array($this, 'checkConfig'), 10, 1);
        //ban hosts
        $this->ban_hosts = array('Y2l0eXZpbGxlY2hhdC5jb20=');
    }

    /**
     * Set the default option if empty
     * @param string $options_name
     * @param array|string $default_value
     * @return array
     */
    public function setDefaultValue($options_name, $default_value)
    {

        if (isset($this->options[$options_name])) {
            if (is_array($default_value)) {
                if (count($this->options[$options_name]) == 0) {
                    $this->options[$options_name] = $default_value;
                } else {
                    $this->options[$options_name] = wp_parse_args($this->options[$options_name], $default_value);
                }
            } else {
                if ($this->options[$options_name] == '') {
                    $this->options[$options_name] = $default_value;
                }
            }
        } else {
            $this->options[$options_name] = $default_value;
        }
    }

    /**
     * defaultOptions Options
     * @param   Array   list of Options
     * @param   object   wpdb instance
     * @return  void
     */
    public function checkConfig($options)
    {
        global $AWD_facebook;
        $this->options = $options;

        //Languages
        if (!isset($this->options['locale'])) {
            if (defined('WPLANG')) {
                if (WPLANG == '') {
                    $this->setDefaultValue('locale', 'en_US');
                } else {
                    $this->setDefaultValue('locale', WPLANG);
                }
            }
        }

        //Permissions
        $perms = $perms_admin = isset($this->options['perms']) ? $this->options['perms'] : '';
        $array_perms = explode(",", $perms);
        if (!in_array('email', $array_perms))
            $perms = rtrim('email,' . $perms, ',');

        if (current_user_can('manage_options'))
            if (!in_array('manage_pages', $array_perms))
                $perms_admin = 'manage_pages,publish_stream';
        $perms = str_replace(' ', '', rtrim($perms, ','));
        $this->setDefaultValue('perms', $perms);

        //always reset perms admin as we can't manage them
        $perms_admin = str_replace(' ', '', rtrim($perms . ',' . $perms_admin, ','));
        $this->options['perms_admin'] = $perms . ' ' . $perms_admin;

        //Plugin and options
        $this->setDefaultValue('connect_enable', 0);
        $this->setDefaultValue('use_extended_access_token', 1);
        $this->setDefaultValue('open_graph_enable', 1);
        $this->setDefaultValue('connect_fbavatar', 0);
        $this->setDefaultValue('publish_to_profile', 0);
        $this->setDefaultValue('publish_to_pages', 0);
        $this->setDefaultValue('publish_message_text', null);
        $this->setDefaultValue('publish_read_more_text', __('Read More', $AWD_facebook::PTD));
        $this->setDefaultValue('fb_publish_to_pages', null);
        $this->setDefaultValue('templates_path', dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'views');

        //API
        $this->setDefaultValue('app_id', '');
        $this->setDefaultValue('admins', '');
        $this->setDefaultValue('app_secret_key', '');
        $this->setDefaultValue('admins', '');
        $this->setDefaultValue('timeout', 10);
        $this->setDefaultValue('app_infos', array());

        //OPENGRAPH
        $this->setDefaultValue('opengraph_objects', array());
        $this->setDefaultValue('opengraph_object_links', array());
        $this->setDefaultValue('opengraph_contexts', array(
            'frontpage' => __('Frontpage', $AWD_facebook::PTD),
            'page' => __('Pages', $AWD_facebook::PTD),
            'post' => __('Posts', $AWD_facebook::PTD),
            'archive' => __('Archives', $AWD_facebook::PTD),
            'author' => __('Authors', $AWD_facebook::PTD)
        ));

        //Plugins options
        $likebutton = array
            (
            'href' => home_url(),
            'send' => 0,
            'width' => 300,
            'height' => 35,
            'colorscheme' => 'light',
            'show_faces' => 0,
            'font' => 'arial',
            'action' => 'like',
            'layout' => 'standard',
            'type' => 'html5',
            'ref' => '',
            'on_pages' => 0,
            'place_on_pages' => 'top',
            'on_posts' => 0,
            'place_on_posts' => 'top',
            'on_custom_post_types' => 0,
            'place_on_custom_post_types' => 'top',
            'exclude_post_type' => '',
            'exclude_terms_slug' => '',
            'exclude_post_id' => ''
        );
        $this->setDefaultValue('likebutton', $likebutton);

        $likebox = array
            (
            'href' => home_url(),
            'width' => 292,
            'height' => 300,
            'colorscheme' => 'light',
            'show_faces' => 0,
            'stream' => 0,
            'type' => 'html5',
            'border_color' => '',
            'force_wall' => '',
            'header' => 0
        );
        $this->setDefaultValue('likebox', $likebox);

        $url = parse_url(home_url());
        $activitybox = array
            (
            'domain' => $url['host'],
            'width' => 292,
            'height' => 300,
            'colorscheme' => 'light',
            'font' => 'arial',
            'show_faces' => 0,
            'type' => 'html5',
            'border_color' => '',
            'recommendations' => 0,
            'header' => 0,
            'filter' => '',
            'linktarget' => '_blank',
            'ref' => '',
            'max_age' => '',
        );
        $this->setDefaultValue('activitybox', $activitybox);

        $shared_activitybox = array
            (
            'width' => 292,
            'height' => 300,
            'font' => 'arial'
        );
        $this->setDefaultValue('shared_activitybox', $shared_activitybox);

        $loginbutton = array
            (
            'display_on_login_page' => 0,
            'display_on_register_page' => 0,
            'login_redirect_url' => '',
            'logout_redirect_url' => '',
            'logout_label' => __('Logout', $AWD_facebook::PTD),
            'show_profile_picture' => 1,
            'show_faces' => 0,
            'maxrow' => 1,
            'width' => 200,
            'image' => $AWD_facebook->pluginImagesUrl . 'f-connect.png'
        );
        $this->setDefaultValue('loginbutton', $loginbutton);

        $commentsbox = array
            (
            'href' => home_url(),
            'colorscheme' => 'light',
            'width' => 500,
            'num_posts' => 10,
            'type' => 'html5',
            'mobile' => 0,
            'on_pages' => 0,
            'on_posts' => 0,
            'on_custom_post_types' => 0,
            'exclude_post_id' => '',
            'order_by' => 'social',
            'place' => 'after',
            'comments_template_path' => dirname(dirname(dirname(__FILE__))) . '/views/default_comments.php'
        );
        $this->setDefaultValue('commentsbox', $commentsbox);

        $this->setDefaultValue('content_manager', array(
            'likebutton' => array(
                'redefine' => 0,
                'enabled' => 1,
                'place' => 'top'
            ),
            'fbpublish' => array(
                'to_pages' => $this->options['publish_to_pages'],
                'to_profile' => $this->options['publish_to_profile'],
                'message_text' => $this->options['publish_message_text'],
                'read_more_text' => $this->options['publish_read_more_text']
            ),
            'opengraph' => array(
                'object_link' => ''
            ),
        ));

        $this->options['curl_options'] = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->options['timeout'],
            CURLOPT_USERAGENT => 'facebook-php-3.2',
            CURLOPT_SSL_VERIFYPEER => 0
        );

        return $this->options;
    }

    /**
     * Getter
     * Options
     * @return Array list of Options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Setter
     * Options
     * @param Array list of Options
     * @return void
     */
    public function setOptions($options)
    {
        //merge old options with new one
        $default = get_option($this->filterName);
        $this->options = wp_parse_args($options, $default);
    }

    /**
     * Load
     * Load Options From database and apply filter : apply_filters($this->filterName, get_option($this->filterName));
     * @return void
     */
    public function load()
    {
        $this->options = apply_filters($this->filterName, get_option($this->filterName));
    }

    /**
     * Save
     * Save options in options table wp
     */
    public function save()
    {
        update_option($this->filterName, $this->checkConfig($this->options));
    }

    /**
     * Add option
     * Save options in options table wp
     */
    public function updateOption($name, $value, $flush = false)
    {
        $this->options[$name] = $value;
        if ($flush === true)
            $this->save();

        return $this->options[$name];
    }

    /**
     * reset
     * reset all Options with a new empty array.
     */
    public function reset()
    {
        update_option($this->filterName, array());
    }

}

?>