<?php

namespace AHWEBDEV\FacebookAWD\Extension\Provider\Drupal\Controller;

use AHWEBDEV\FacebookAWD\Extension\Model\BackendController as BaseController;
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
        $items = array();

        //create the block in admin menu
        $itemAdminHook = 'admin/config/facebookAWD';
        $items[$itemAdminHook] = array(
            'title' => FacebookAWD::PLUGIN_NAME,
            'description' => 'Facebook AWD add Facebook capabilities to Drupal and more...',
            'page callback' => 'system_admin_menu_block_page',
            'access arguments' => array('administer site configuration'),
            'file' => 'system.admin.inc',
            'file path' => drupal_get_path('module', 'system')
        );
        $this->setAdminMenuHook($itemAdminHook);

        //Add the settings page
        $itemSettingsHook = 'admin/config/facebookAWD/settings';
        $items[$itemSettingsHook] = array(
            'title' => 'Settings',
            'description' => 'Configure your Facebook Application',
            'page callback' => 'facebokoAWD_settings',
            'page arguments' => array($itemSettingsHook),
            'access arguments' => array('administer site configuration')
        );
        $this->setSettingsMenuHook($itemSettingsHook);

        //Add the plugins page
        $itemPluginsHook = 'admin/config/facebookAWD/plugin';
        $items[$itemPluginsHook] = array(
            'title' => 'Plugins',
            'description' => 'Configure your Facebook plugins',
            'access arguments' => array('administer site configuration'),
            'page arguments' => array($itemPluginsHook),
            'page callback' => 'facebokoAWD_settings',
        );
        $this->setPluginsMenuHook($itemPluginsHook);
        return $items;
    }

    /**
     * Render the sidebar content
     * @param string $hook
     * @return string
     */
    public function sidebarContent($hook)
    {
        return '<h4>My Facebook</h4>';
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
            drupal_add_js(drupal_get_path('module', FacebookAWD::PLUGIN_SLUG . 'Drupal') . '/' . FacebookAWD::getAsset($path));
        }

        //add css
        foreach ($assets['style'] as $fileName => $path) {
            drupal_add_css(drupal_get_path('module', FacebookAWD::PLUGIN_SLUG . 'Drupal') . '/' . FacebookAWD::getAsset($path));
        }

        $items = $this->adminMenu();
        $params = array();
        $menuItems = array();
        $items = array_slice($items, 1);
        foreach($items as $path => $item){
            $class = '';
            if(isset($item['page arguments'][0]) && $hook == $item['page arguments'][0]){
                $params['title'] = t($item['title']);
                $class = 'active';
            }
            $menuItems[] = array(
                'class' => $class,
                'url' => '/'.$path,
                'title' => t($item['description']),
                'value' => t($item['title'])
            );
        }

        $params['menuItems'] = $menuItems;
        $params['sidebar'] = $this->sidebarContent($hook);

        return parent::renderContent($params);
    }

}

?>
