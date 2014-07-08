<?php

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Admin\Admin;
use AHWEBDEV\FacebookAWD\Api\Api;
use AHWEBDEV\FacebookAWD\Controller\AdminController;
use AHWEBDEV\FacebookAWD\Controller\InstallController;
use AHWEBDEV\FacebookAWD\Listener\RequestListener;
use AHWEBDEV\FacebookAWD\Model\Application;
use AHWEBDEV\FacebookAWD\Model\Option;
use AHWEBDEV\Framework\Container;
use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\OptionManager\OptionManager;
use AHWEBDEV\Framework\Plugin\Plugin;
use AHWEBDEV\Framework\TemplateManager\TemplateManager;
use ReflectionClass;
use RuntimeException;

/**
 * Facebook AWD All in One
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class FacebookAWD extends Container
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->title = 'Facebook AWD';
        $this->slug = 'facebookawd';
        $this->ptd = 'facebookawd';
        $this->rootPath = __DIR__;

        $publicUrl = plugins_url(null, __FILE__) . '/Resources/public/';
        $prefix = $this->getSlug();

        $this->assets = array(
            'script' => array(
                $prefix . '-socket-io' => 'http://localhost:8081/socket.io/socket.io.js',
                $prefix . '-socket-js' => $publicUrl . 'js/socket.js',
                $prefix . '-bootstrap-js' => $publicUrl . 'js/bootstrap.min.js',
                $prefix . '-jquery-validate-js' => $publicUrl . 'js/jquery.validate.min.js',
                //'bootstrap-tab-js' => 'js/bootstrap/tab.js',
                //'bootstrap-transition-js' => 'js/bootstrap/transition.js',
                //'google-code-prettify-js' => 'js/google-code-prettify/prettify.js',
                $prefix . '-admin-js' => $publicUrl . 'js/facebook_awd_admin.js',
                $prefix . '-global-js' => $publicUrl . 'js/facebook_awd.js',
            ),
            'style' => array(
                $prefix . '-bootstrap-css' => $publicUrl . 'css/bootstrap.css',
                $prefix . '-animate-css' => $publicUrl . 'css/animate.css',
            //'google-code-prettify-css' => 'css/google-code-prettify/prettify.css',
            )
        );
        parent::__construct();
    }

    /**
     * Init
     */
    public function init(ContainerInterface $container = null)
    {
        if ($container) {
            throw new RuntimeException('FacbookAWD cannot have parent container');
        }
        //init services
        $this->initServices();

        //init controllers
        $this->initControllers();

        //init listeners
        $this->initListeners();

        //init front end action
        $this->get('listener.request_listener')->init();

        return $this;
    }

    /**
     * Init the default services
     */
    public function initServices()
    {
        $tm = new TemplateManager($this);
        $this->set('services.template_manager', $tm);

        $om = new OptionManager($this);
        $this->set('services.option_manager', $om);

        //load models
        if (!$application = $om->load('options.application')) {
            $application = new Application();
        }
        $this->set('services.application', $application);

        if (!$options = $om->load('options')) {
            $options = new Option();
        }
        $this->set('services.options', $options);

        //load api
        $api = null;
        if ($application) {
            $api = new Api($application);
            $this->set('services.api', $api);
        }
        $this->set('services.api', $api);

        $admin = new Admin($this);
        $this->set('admin', $admin);
    }

    /**
     * Set the defaults listeners
     */
    public function initListeners()
    {
        $requestListener = new RequestListener($this);
        $this->set('listener.request_listener', $requestListener);
    }

    /**
     * Set the defaults controllers
     */
    public function initControllers()
    {
        $adminController = new AdminController($this, $this->get('admin'));
        $this->set('backend.controller', $adminController);

        $installController = new InstallController($this, $this->get('admin'));
        $this->set('backend.install_controller', $installController);
    }

    /**
     * Init the default plugins
     */
    public function preloadPlugins()
    {
        require_once dirname(__FILE__) . '/Plugin/LikeButton/boot.php';
        require_once dirname(__FILE__) . '/Plugin/LikeBox/boot.php';
    }

    /**
     *
     * @param  string                            $name
     * @param  Plugin                            $plugin
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    public function registerPlugin($name, Plugin $plugin)
    {
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $f = new ReflectionClass($plugin);
        $this->plugins[$name] = array(
            'data' => \get_plugin_data(dirname($f->getFileName()) . '/boot.php', false, true),
            'instance' => $plugin
        );
        return $this;
    }

    /**
     * Get the infos of a plugins that use a boot file
     * @return array
     */
    public function getInfos()
    {
        $f = new ReflectionClass($this);

        return \get_plugin_data(dirname($f->getFileName()) . '/boot.php', false, true);
    }

    /**
     * Launch the container
     */
    public function launch()
    {
        $this->get('admin')->init();
        add_action('shutdown', array($this, 'shutdown'), 1000);
    }

    /*     * ***
     * Intefaced ???
     */

    /**
     * Shutdown the process
     * very last request
     */
    public function shutdown()
    {
        $this->store();
    }

    /**
     * Store the facebook AWD instance into memory
     */
    public function store($clean = false)
    {
        if ($this->apcLoaded && !$clean) {
            apc_add('FacebookAWD', $this, 30);
        }
        if ($clean) {
            apc_delete('FacebookAWD');
        }
    }

    /**
     * Create a Facebook AWD instance and store it in apc if enabled.
     * If Instance exists in cache, FacebookAWD instance is returned
     * @return \self
     */
    public static function boot()
    {
        $instance = null;
        $apc = extension_loaded('apc');
        if ($apc) {
            $instance = apc_fetch('FacebookAWD');
        }
        if (!$instance) {
            $instance = new self();
            $instance->init();
        }
        $instance->preloadPlugins();
        apply_filters('facebookawd', $instance);
        add_action('plugins_loaded', array($instance, 'launch'));
        //$instance->store();
        return $instance;
    }

}
