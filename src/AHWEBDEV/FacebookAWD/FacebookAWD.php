<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Admin\Admin;
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
use Facebook\FacebookSession;
use ReflectionClass;
use RuntimeException;

/**
 * FacebookAWD
 *
 * This file is the base container of the Facebook AWD extension
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
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

        $publicUrl = plugins_url(null, __FILE__) . '/Resources/public';
        $prefix = $this->getSlug();

        $this->assets = array(
            'script' => array(
                /* 'socket-io' => array(
                  'src' => 'http://localhost:8081/socket.io/socket.io.js'
                  ),
                  'socket-js' => array(
                  'src' => $publicUrl . '/js/socket.js'
                  ), */
                $prefix . 'bootstrap' => array(
                    'src' => $publicUrl . '/js/bootstrap/bootstrap.min.js'
                ),
                $prefix . 'jquery-validate' => array(
                    'src' => $publicUrl . '/js/jquery.validate.min.js',
                    'deps' => array('jquery')
                ),
                $prefix . 'admin' => array(
                    'src' => $publicUrl . '/js/admin/admin.js',
                    'deps' => array('jquery')
                ),
                $prefix . 'admin-init' => array(
                    'src' => $publicUrl . '/js/admin/init.js',
                    'deps' => array($prefix . 'admin', 'jquery')
                ),
                $prefix => array(
                    'src' => $publicUrl . '/js/init.js',
                    'deps' => array('jquery')
                )
            ),
            'style' => array(
                $prefix . 'bootstrap' => array(
                    'src' => $publicUrl . '/css/bootstrap/bootstrap.css'
                ),
                $prefix . 'animate' => array(
                    'src' => $publicUrl . '/css/animate.css'
                )
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

        apply_filters('facebookawd', $this);

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
        $fbAppSession = null;
        if ($application) {
            FacebookSession::setDefaultApplication($application->getId(), $application->getSecretKey());
            //maybe not required...
            $fbAppSession = FacebookSession::newAppSession($application->getId(), $application->getSecretKey());
        }
        $this->set('services.facebook.appSession', $fbAppSession);

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
        $this->set('controller.backend', $adminController);

        $installController = new InstallController($this, $this->get('admin'));
        $this->set('controller.install', $installController);
    }

    /**
     * {@inheritdoc}
     */
    public function registerPlugin($name, Plugin $plugin)
    {
        $this->plugins[$name] = $plugin;

        return $this;
    }

    /**
     * Register Assets on this container
     */
    public function registerAssets()
    {
        $default = array(
            'src' => null,
            'deps' => array(),
            'version' => null
        );
        foreach ($this->assets as $type => $assetsType) {
            foreach ($assetsType as $id => $asset) {
                $asset = array_replace_recursive($default, $asset);
                $media = 'all';
                if ($type === 'script') {
                    $media = true;
                }
                call_user_func_array('wp_register_' . $type, array($id, $asset['src'], $asset['deps'], $asset['version'], $media));
            }
        }
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
    }

    /**
     * Return a token form Config
     * @return array
     */
    public function getTokenFormConfig()
    {
        return array(
            'token' => array(
                'name' => 'token',
                'type' => 'hidden',
                'attr' => array(),
                'group' => false,
                'value' => wp_create_nonce('fawd-token')
            )
        );
    }

    /**
     * Create a Facebook AWD instance
     * 
     * @return \self
     */
    public static function boot()
    {
        $instance = new self();
        $instance->init();
        do_action('facebookawd_register_plugins', $instance);
        add_action('plugins_loaded', array($instance, 'launch'));
        return $instance;
    }

}
