<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeButton\Controller;

use AHWEBDEV\FacebookAWD\Controller\HomeController as BaseController;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * SettingsController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD\Extension\Wordpress
 */
class SettingsController extends BaseController
{

    /**
     * Override default home
     */
    public function init()
    {
        $this->initTemplates();
        add_action('admin_menu', array($this, 'adminMenu'), 11);
    }

    public function adminMenu()
    {
        $pageHook = add_submenu_page($this->container->getRoot()->getSlug(), 'likebutton', __('Like Button', $this->container->getPtd()), 'manage_options', $this->container->getSlug(), array($this, 'index'));
        $backendCtrl = $this->container->getParent()->get('backend.controller');
        $backendCtrl->addAdminMenuHook($this->container->getSlug(), $pageHook);

        add_action('add_meta_boxes_' . $pageHook, array($this, 'addMetaBoxes'));
        do_action('add_meta_boxes_' . $pageHook, $pageHook);
        remove_meta_box($pageHook . '_plugins', $pageHook, 'normal');

        $title = __('Settings', $this->container->getPtd());
        add_meta_box($pageHook . '_likebutton_settings', $title, array($this, 'contentSection'), $pageHook, 'normal', 'default');

        $title = __('Display', $this->container->getPtd());
        add_meta_box($pageHook . '_likebutton_display', $title, array($this, 'contentSection'), $pageHook, 'normal', 'default');

        $title = __('Preview', $this->container->getPtd());
        add_meta_box($pageHook . '_likebutton_preview', $title, array($this, 'contentSection'), $pageHook, 'normal', 'default');
    }

    /**
     * Return index content
     */
    public function index()
    {
        echo $this->render($this->templates['index'], array(
            'title' => $this->container->getTitle().' <a class="button-secondary" href="?page='.$this->container->getRoot()->getSlug().'">Back</a>',
            'application' => $this->container->getRoot()->get('services.application'),
            'args' => array(),
            'boxes' => array(
                array(
                    'type' => 'do_accordion_sections',
                    //'type' => 'do_meta_boxes',
                    'context' => 'normal'
                ),
            ),
            'boxesSide' => array(
                array(
                    'type' => 'do_meta_boxes',
                    'context' => 'side'
                )
            )
        ));
    }

    public function contentSection()
    {
        echo 111;
    }

}
