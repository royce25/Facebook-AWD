<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\Wordpress\Admin\MetaboxInterface;
use AHWEBDEV\Wordpress\Controller\AdminMenuController as BaseController;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * AdminController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD\Extension\Wordpress
 */
class AdminController extends BaseController implements MetaboxInterface
{

    /**
     *
     * @return string
     */
    public function getMenuType()
    {
        return self::TYPE_MENU;
    }

    /**
     *
     * @return string
     */
    public function getMenuSlug()
    {
        return $this->container->getSlug();
    }

    /**
     *
     * @return string
     */
    public function getMenuTitle()
    {
        return $this->container->getTitle();
    }

    /**
     * get the templates
     */
    public function getTemplates()
    {
        return array(
            'index' => $this->container->getRoot()->getRootPath() . '/Resources/views/admin/metaboxes.html.php',
            'welcome' => $this->container->getRoot()->getRootPath() . '/Resources/views/admin/home/welcome.html.php',
            'plugins' => $this->container->getRoot()->getRootPath() . '/Resources/views/admin/home/plugins.html.php',
            'donate' => $this->container->getRoot()->getRootPath() . '/Resources/views/admin/home/donate.html.php',
            'documentation' => $this->container->getRoot()->getRootPath() . '/Resources/views/admin/home/documentation.html.php'
        );
    }

    /**
     * Add meta boxes
     */
    public function addMetaBoxes($pageHook)
    {
        $title = '<span class="facebookAWD"><span class="glyphicon glyphicon-th-list"></span></span> ' . __('Plugins', $this->container->getPtd());
        add_meta_box($pageHook . '_plugins', $title, array($this, 'pluginsSection'), $pageHook, 'normal', 'default');

        $title = '<span class="facebookAWD"><span class="glyphicon glyphicon-info-sign"></span></span> ' . __('Documentation', $this->container->getPtd());
        add_meta_box($pageHook . '_documentation', $title, array($this, 'documentationSection'), $pageHook, 'side', 'default');

        $title = '<span class="facebookAWD"><span class="glyphicon glyphicon-thumbs-up"></span></span> ' . __('Be cool...', $this->container->getPtd());
        add_meta_box($pageHook . '_donate', $title, array($this, 'donateSection'), $pageHook, 'side', 'default');

        //add_meta_box($pageHook . '_welcome', __('Welcome', $this->container->getPtd()), array($this, 'welcomeSection'), $pageHook, 'normal', 'high');
        add_screen_option('layout_columns', array('max' => 2, 'default' => 1));
    }

    /**
     * Return index content
     */
    public function index()
    {
        echo $this->render($this->getTemplates()['index'], array(
            'application' => $this->container->getRoot()->get('services.application'),
            'args' => array(),
            'boxes' => array(
                array(
                    'type' => 'do_meta_boxes',
                    'context' => 'normal'
                )
            ),
            'boxesSide' => array(
                array(
                    'type' => 'do_accordion_sections',
                    'type' => 'do_meta_boxes',
                    'context' => 'side'
                )
            )
        ));
    }

    /**
     * Welcome section
     */
    public function welcomeSection()
    {
        $application = $this->container->getRoot()->get('services.application');
        echo $this->render($this->getTemplates()['welcome'], array('application' => $application));
    }

    /**
     * Plugins Section
     */
    public function pluginsSection()
    {
        echo $this->render($this->getTemplates()['plugins'], array(
            'plugins' => $this->container->getRoot()->getPlugins()
        ));
    }

    /**
     * Donate section
     */
    public function donateSection()
    {
        echo $this->render($this->getTemplates()['donate']);
    }

    /**
     * Documentation Section
     */
    public function documentationSection()
    {
        echo $this->render($this->getTemplates()['documentation']);
    }

}
