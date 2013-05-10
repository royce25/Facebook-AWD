<?php

namespace AHWEBDEV\FacebookAWD\Extension\Drupal\Controller;

use AHWEBDEV\FacebookAWD\Extension\Wordpress\Extension;
use AHWEBDEV\FacebookAWD\FacebookAWD;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BackendController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @packae FacebookAWD\Extension\Wordpress
 */
class BackendController implements BackendControllerInterface
{

    /**
     * Constructor
     *
     * @param \AHWEBDEV\FacebookAWD\ExtensionBridge\ExtensionBridgeInterface $extensionBridge
     */
    public function __construct(ExtensionBridgeInterface $extensionBridge)
    {
        $this->facebookAWD = $extensionBridge->getFacebookAWD();
        add_action('after_setup_theme', array(&$this, 'launch'));
    }

    public function menuHook()
    {
        $items = array();
        $items['admin/config/facebookAWD'] = array(
            'title' => FacebookAWD::PLUGIN_NAME,
            'description' => 'My Description',
            'position' => 'left',
            'weight' => -100,
            'page callback' => 'system_admin_menu_block_page',
            'access arguments' => array('administer site configuration'),
            'file' => 'system.admin.inc',
            'file path' => drupal_get_path('module', 'system'),
        );

        //We need at least one child item, otherwise parent will not show up
        $items['admin/config/facebookAWD/child-name'] = array(
            'title' => 'Settings',
            'description' => 'Configure your Facebook Application',
            'page callback' => 'drupal_goto',
            'page arguments' => array('my-path'),
            'access arguments' => array('administer site configuration'),
        );
        return $items;
    }

}

?>
