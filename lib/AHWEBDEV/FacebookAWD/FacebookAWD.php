<?php

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Api\Api;
use AHWEBDEV\FacebookAWD\Controller\BackendController;
use AHWEBDEV\FacebookAWD\Controller\HomeController;
use AHWEBDEV\FacebookAWD\Controller\InstallController;
use AHWEBDEV\FacebookAWD\Model\Application;
use AHWEBDEV\Framework\Container as BaseContainer;
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
     * The name of the plugin
     */

    const PLUGIN_NAME = 'Facebook AWD';

    /**
     * The slug of the plugin
     */

    const PLUGIN_SLUG = 'FacebookAWD';

    /**
     * The title of the admin interface
     */

    const PLUGIN_ADMIN_NAME = 'Facebook Admin';

    /**
     * The plugin text domain
     */

    const PTD = self::PLUGIN_SLUG;

    /**
     * All assets required to work with facebook AWD.
     *
     * @var array
     */
    protected $assets = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->assets = array(
            'script' => array(
                //'bootstrap-js' => 'js/bootstrap.min.js',
                'jquery-validate-js' => 'js/jquery.validate.min.js',
                'bootstrap-tab-js' => 'js/bootstrap/tab.js',
                'bootstrap-transition-js' => 'js/bootstrap/transition.js',
                'google-code-prettify-js' => 'js/google-code-prettify/prettify.js',
                'admin-js' => 'js/facebook_awd_admin.js',
                'global-js' => 'js/facebook_awd.js',
            ),
            'style' => array(
                'bootstrap-css' => 'css/bootstrap.css',
                'google-code-prettify-css' => 'css/google-code-prettify/prettify.css',
            )
        );
        parent::__construct();
    }

    /**
     * Return the assets
     *
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set the assets
     *
     * @param array $assets
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    public function setAssets(array $assets)
    {
        $this->assets = $assets;
        return $this;
    }

    /**
     * Return Asset
     *
     * @param string $path
     * @param string $basePath
     */
    public static function getResource($path, $basePath = '')
    {
        if (empty($basePath))
            $basePath = '';

        return 'lib/AHWEBDEV/FacebookAWD/Resources/public/' . $path;
    }

    /**
     * Return this file name
     *
     * @return string
     */
    public function getFile()
    {
        $f = new ReflectionClass($this);
        return $f->getFileName();
    }

    /**
     * Init
     */
    public function init()
    {

        $om = $this->get('services.option_manager');

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

        //load controllers
        $backendController = new BackendController($this);
        $this->set('backend.controller', $backendController);

        $installController = new InstallController($this);
        $this->set('backend.install_controller', $installController);

        $homeController = new HomeController($this);
        $this->set('backend.home_controller', $homeController);

        //start plugin
        add_action('after_setup_theme', array(&$this, 'launch'));

        return $this;
    }

    /**
     * Launch the extension and add functionnality to wprdoress hook
     */
    public function launch()
    {
        if (is_admin()) {
            $this->get('backend.controller')->init();
        }
    }

}

?>