<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 * @author Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */

namespace AHWEBDEV\Wordpress\PluginBundle\Admin;

use AHWEBDEV\Wordpress\PluginBundle\Admin\AdminPool;
use AHWEBDEV\Wordpress\PluginBundle\Routing\WpActionRouter;

/**
 * AdminManager
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class AdminManager
{

    /**
     * The pool of admin pages under this manager
     * 
     * @var \AHWEBDEV\Wordpress\PluginBundle\Admin\AdminPool 
     */
    protected $adminPool;

    /**
     * The wordpress action router
     * 
     * @var WpActionRouter 
     */
    protected $wpRouter;

    /**
     * Constructor
     * 
     * @param AdminPool $adminPool
     */
    public function __construct(AdminPool $adminPool, WpActionRouter $wpRouter)
    {
        $this->adminPool = $adminPool;
        $this->wpRouter = $wpRouter;
    }

    public function boot()
    {
        add_action('admin_menu', array($this, 'initMenuHook'));
    }

    public function initMenuHook()
    {
        foreach ($this->adminPool->all() as $adminPage) {
            //add_action('admin_init', array($adminPage, 'init'));
            $this->initMenu($adminPage);
        }
        /* add_action('admin_print_styles-' . $this->pageHook, array($this, 'enqueueStyles'));
          add_action('admin_print_scripts-' . $this->pageHook, array($this, 'enqueueScripts'));
          add_action('admin_print_styles-widgets.php', array($this, 'enqueueScripts'));
          add_action('admin_print_styles-widgets.php', array($this, 'enqueueStyles')); */
    }

    public function initMenu(\AHWEBDEV\Wordpress\PluginBundle\Admin\AdminPage $page)
    {
        $capability = 'manage_options';
        if ($page->getType() === \AHWEBDEV\Wordpress\PluginBundle\Admin\AdminPage::TYPE_SUBPAGE) {
            $pageHook = add_submenu_page($page->getParent()->getId(), $page->getTitle(), $page->getTitle(), $capability, $page->getId(), $this->wpRouter->getDefaultAction());
        } else {
            $pageHook = add_menu_page($page->getTitle(), $page->getTitle(), $capability, $page->getId(), $this->wpRouter->getDefaultAction(), $page->getIconUrl());
            add_submenu_page($page->getId(), '', 'General', $capability, $page->getId());
        }
        $page->setPageHook($pageHook);
    }

}
