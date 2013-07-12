<?php

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Extension\ExtensionBridgeInterface;
use AHWEBDEV\FacebookAWD\OptionManager\OptionManager;
use AHWEBDEV\FacebookAWD\TemplateManager\TemplateManager;
use ReflectionClass;

/**
 * Facebook AWD All in One
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
class FacebookAWD
{
    /**
     * The name of the plugin
     */

    const PLUGIN_NAME = 'Facebook AWD';

    /**
     * The slug of the plugin
     */

    const PLUGIN_SLUG = 'facebookAWD';

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

}

?>