<?php

namespace AHWEBDEV\FacebookAWD;

use AHWEBDEV\FacebookAWD\Extension\Model\ExtensionBridgeInterface;
use AHWEBDEV\FacebookAWD\OptionManager\OptionManager;
use AHWEBDEV\FacebookAWD\TemplateManager\TemplateManager;

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

    const PLUGIN_SLUG = 'facebook_awd';

    /**
     * The title of the admin interface
     */

    const PLUGIN_ADMIN_NAME = 'Facebook Admin';

    /**
     * The plugin text domain
     */

    const PTD = self::PLUGIN_SLUG;

    /**
     *
     * @var array
     */
    protected $extensionsBridge = array();

    /**
     *
     * @var TemplateManager
     */
    protected $templateManager;

    /**
     *
     * @var OptionManager
     */
    protected $optionManager;

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
                'bootstrap-js' => 'js/bootstrap.min.js',
                'google-code-prettify-js' => 'js/google-code-prettify/prettify.js',
                'admin-js' => 'js/facebook_awd_admin.js',
                'global-js' => 'js/facebook_awd.js',
            ),
            'style' => array(
                'bootstrap-css' => 'css/bootstrap.css',
                'google-code-prettify-css' => 'css/google-code-prettify/prettify.css',
            )
        );
        $this->optionManager = new OptionManager($this);
        $this->templateManager = new TemplateManager($this);
    }

    /**
     * Return the OptionManager
     * @return \AHWEBDEV\FacebookAWD\OptionManager
     */
    public function getOptionManager()
    {
        return $this->optionManager;
    }

    /**
     * Set the OptionManager
     * @param \AHWEBDEV\FacebookAWD\OptionManager $optionManager
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    public function setOptionManager(OptionManager $optionManager)
    {
        $this->optionManager = $optionManager;
        return $this;
    }

    /**
     * Return the TemplateManager
     * @return \AHWEBDEV\FacebookAWD\TemplateManager\TemplateManager
     */
    public function getTemplateManager()
    {
        return $this->templateManager;
    }

    /**
     *
     * @param \AHWEBDEV\FacebookAWD\TemplateManager\TemplateManager $templateManager
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    public function setTemplateManager(TemplateManager $templateManager)
    {
        $this->templateManager = $templateManager;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getExtensionsBridge()
    {
        return $this->extensionsBridge;
    }

    /**
     *
     * @param array $extensionsBridge
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD$
     */
    public function setExtensionsBridge(array $extensionsBridge)
    {
        $this->extensions = $extensionsBridge;
        return $this;
    }

    /**
     *
     * @param \AHWEBDEV\FacebookAWD\Extension\Model\ExtensionBridgeInterface $extensionBridge
     * @return \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    public function addExtensionBridge(ExtensionBridgeInterface $extensionBridge)
    {
        $this->extensionsBridge[] = $extensionBridge;
        return $this;
    }

    /**
     *
     * @return type
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
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
     *
     * @param string $path
     * @param string $basePath
     */
    public static function getAsset($path, $basePath = '')
    {
        if ($basePath == '')
            $basePath = 'facebook-awd/lib/AHWEBDEV/FacebookAWD/Resources/public/';

        return $basePath . $path;
    }

    public function getFile()
    {
        $f = new \ReflectionClass($this);
        return $f->getFileName();
    }

}

?>