<?php

namespace AHWEBDEV\FacebookAWD\Extension\Provider\Wordpress;

use AHWEBDEV\FacebookAWD\Extension\Model\Extension as BaseExtension;
use AHWEBDEV\FacebookAWD\Extension\Provider\Wordpress\Controller\BackendController;
use AHWEBDEV\FacebookAWD\FacebookAWD;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extension
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @packae FacebookAWD\Extension\Wordpress
 */
class Extension extends BaseExtension
{

    /**
     * Init
     */
    public function init()
    {
        add_action('after_setup_theme', array(&$this, 'launch'));
        add_action("init", array(&$this, 'registerAssets'));
    }

    /**
     * Launch the extension and add functionnality to wprdoress hook
     */
    public function launch()
    {
        $this->setBackendController(new BackendController($this));
    }

    /**
     * Register all assets inside the wordpress assets management system
     */
    public function registerAssets()
    {
        $assets = $this->facebookAWD->getAssets();
        foreach ($assets as $type => $files) {
            foreach ($files as $fileName => $path) {
                $media = 'all';
                $deps = array();
                if ($type === 'script') {
                    $deps = array('jquery');
                    $media = true;
                }
                call_user_func_array('wp_register_' . $type, array('facebook-awd-' . $fileName, plugins_url(FacebookAWD::getAsset($path)), $deps, null, $media));
            }
        }
    }

}

?>
