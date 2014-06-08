<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeButton\Controller;

use AHWEBDEV\Wordpress\Admin\MetaboxInterface;
use AHWEBDEV\Wordpress\Controller\AdminMenuController as BaseController;

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
class SettingsController extends BaseController implements MetaboxInterface
{

    /**
     *
     * @return string
     */
    public function getMenuType()
    {
        return self::TYPE_SUBMENU;
    }

    /**
     *
     * @return string
     */
    public function getMenuSlug()
    {
        return $this->container->getRoot()->getSlug();
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
     *
     * @param string $pageHook
     */
    public function addMetaBoxes($pageHook)
    {
        $pageHook = $this->admin->getAdminMenuHook($this->container->getSlug());

        //Call the metaboxes and remove the unwanted one.
        $adminController = $this->container->getRoot()->get('backend.controller');
        $adminController->addMetaboxes($pageHook);
        remove_meta_box($pageHook . '_plugins', $pageHook, 'normal');

        $titleSettings = __('Settings', $this->container->getPtd());
        add_meta_box($pageHook . '_likebutton_settings', $titleSettings, array($this, 'contentSection'), $pageHook, 'normal', 'default');

        $titleDisplay = __('Display', $this->container->getPtd());
        add_meta_box($pageHook . '_likebutton_display', $titleDisplay, array($this, 'contentSection'), $pageHook, 'normal', 'default');

        $titlePreview = __('Preview', $this->container->getPtd());
        add_meta_box($pageHook . '_likebutton_preview', $titlePreview, array($this, 'contentSection'), $pageHook, 'normal', 'default');
    }

    /**
     * Return index content
     */
    public function index()
    {
        $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/metaboxes.html.php';
        echo $this->render($template, array(
            'title' => $this->container->getTitle() . ' <a class="button-secondary" href="?page=' . $this->container->getRoot()->getSlug() . '">Back</a>',
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
        echo '<h1>In progress</h1>';
    }

}
