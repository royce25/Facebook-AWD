<?php

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Api\Api;
use AHWEBDEV\FacebookAWD\Controller\BackendController;
use AHWEBDEV\FacebookAWD\Controller\HomeController;
use AHWEBDEV\FacebookAWD\Controller\InstallController;
use AHWEBDEV\FacebookAWD\Listener\RequestListener;
use AHWEBDEV\FacebookAWD\Model\Application;
use AHWEBDEV\Framework\Container as BaseContainer;
use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\OptionManager\OptionManager;
use AHWEBDEV\Framework\Plugin\Plugin;
use AHWEBDEV\Framework\TemplateManager\TemplateManager;
use ReflectionClass;

/**
 * Facebook AWD All in One
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class FacebookAWD extends BaseContainer
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

        $this->assets = array(
            'script' => array(
                'bootstrap-js' => 'js/bootstrap.min.js',
                'jquery-validate-js' => 'js/jquery.validate.min.js',
                //'bootstrap-tab-js' => 'js/bootstrap/tab.js',
                //'bootstrap-transition-js' => 'js/bootstrap/transition.js',
                //'google-code-prettify-js' => 'js/google-code-prettify/prettify.js',
                'admin-js' => 'js/facebook_awd_admin.js',
                'global-js' => 'js/facebook_awd.js',
            ),
            'style' => array(
                'bootstrap-css' => 'css/bootstrap.css',
                'animate-css' => 'css/animate.css',
            //'google-code-prettify-css' => 'css/google-code-prettify/prettify.css',
            )
        );
        parent::__construct();
    }

    /**
     * Return Asset
     *
     * @param string $path
     * @param string $basePath
     */
    public static function getResource($path, $basePath = '')
    {
        if (empty($basePath)) {
            $basePath = '';
        }
        return 'lib/AHWEBDEV/FacebookAWD/Resources/public/' . $path;
    }

    /**
     * Init
     */
    public function init(ContainerInterface $container = null)
    {
        //init services
        $this->initServices();

        //init controllers
        $this->initControllers();

        //init plugins
        $this->initPlugins();

        //init listeners
        $this->initListeners();

        //wordpress boot
        apply_filters('facebookawd_loaded', $this);
        add_action('plugins_loaded', array($this, 'launch'));

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

        //load application
        $application = $om->load('options.application');
        if (!$application) {
            $application = new Application();
        }
        $this->set('services.application', $application);

        //load api
        $api = null;
        if ($application) {
            $api = new Api($application);
            $this->set('services.api', $api);
        }
        $this->set('services.api', $api);

        //load application
        $application = $om->load('options.application');
        if (!$application) {
            $application = new Application();
        }
        $this->set('services.application', $application);
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
        //load controllers
        $backendController = new BackendController($this);
        $this->set('backend.controller', $backendController);

        $installController = new InstallController($this);
        $this->set('backend.install_controller', $installController);

        $homeController = new HomeController($this);
        $this->set('backend.home_controller', $homeController);
    }

    /**
     * Init the default plugins
     */
    public function initPlugins()
    {
        require_once dirname(__FILE__) . '/Plugin/LikeButton/boot.php';
        require_once dirname(__FILE__) . '/Plugin/LikeBox/boot.php';
    }

    /**
     * 
     * @param string $name
     * @param Plugin $plugin
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
        //launch the init of the backend
        if (is_admin()) {
            $this->get('backend.controller')->init();
        }
    }

}
