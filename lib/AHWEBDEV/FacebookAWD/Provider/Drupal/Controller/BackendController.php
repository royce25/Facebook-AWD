<?php

namespace AHWEBDEV\FacebookAWD\Provider\Drupal\Controller;

use AHWEBDEV\FacebookAWD\Extension\Controller\BackendController as BaseController;
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
 * @package FacebookAWD\Extension\Wordpress
 */
class BackendController extends BaseController
{

    /**
     *
     */
    public function init()
    {
        //silence for the moment
    }

    /**
     * Returns the admin menu Items
     * @return string
     */
    public function adminMenu()
    {
        //create the block in admin menu
        $itemAdminHook = 'admin/config/facebookAWD';
        $items = array();
        $items[$itemAdminHook] = array(
            'title' => FacebookAWD::PLUGIN_NAME,
            'description' => 'Facebook AWD add Facebook capabilities to Drupal and more...',
            'page callback' => 'system_admin_menu_block_page',
            'access arguments' => array('administer site configuration'),
            'file' => 'system.admin.inc',
            'file path' => drupal_get_path('module', 'system')
        );

        //Add the plugins page
        $items[$itemAdminHook.'/settings'] = array(
            'title' => 'Settings',
            'description' => 'Configure your Facebook AWD',
            'access arguments' => array('administer site configuration'),
            'page arguments' => array($itemAdminHook.'plugins'),
            'page callback' => 'facebookAWDDrupal_settings',
        );

        return $items;
    }

    /**
     * Render the content
     * @param string $hook
     * @return string
     */
    public function content($hook)
    {
        $assets = $this->facebookAWD->getAssets();

        //add js
        foreach ($assets['script'] as $fileName => $path) {
            drupal_add_js(drupal_get_path('module', FacebookAWD::PLUGIN_SLUG . 'Drupal') . '/' . FacebookAWD::getResource($path));
        }

        //add css
        foreach ($assets['style'] as $fileName => $path) {
            drupal_add_css(drupal_get_path('module', FacebookAWD::PLUGIN_SLUG . 'Drupal') . '/' . FacebookAWD::getResource($path));
        }

        $params['menuItems'] = $this->getMenuItems();

        return parent::render($params);
    }

}

?>
