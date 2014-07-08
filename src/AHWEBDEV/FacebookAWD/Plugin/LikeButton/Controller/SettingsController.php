<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeButton\Controller;

use AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButton;
use AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButtonPostType;
use AHWEBDEV\Framework\TemplateManager\Form;
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
        $adminController = $this->container->getRoot()->get('backend.controller');
        $adminController->addMetaboxes($pageHook);
        remove_meta_box($pageHook . '_plugins', $pageHook, 'normal');

        $postTypes = get_post_types(array('public' => true), 'objects');
        foreach ($postTypes as $postType) {
            add_meta_box($pageHook . '_likebutton_posttype_' . $postType->name . '_settings', $postType->labels->name, array($this, 'settingsSection'), $pageHook, 'normal', 'default', array($postType));
        }
    }

    /**
     * Return index content
     */
    public function index()
    {
        $this->handlesSettingsSection();
        $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/metaboxes.html.php';
        echo $this->render($template, array(
            'title' => $this->container->getTitle() . ' <a class="button-secondary" href="?page=' . $this->container->getRoot()->getSlug() . '">Back</a>',
            'application' => $this->container->getRoot()->get('services.application'),
            'args' => array(),
            'boxes' => array(
                array(
                    //'type' => 'do_accordion_sections',
                    'type' => 'do_meta_boxes',
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

    public function settingsSection($post, array $metaboxData)
    {
        $postType = $metaboxData['args'][0];
        $om = $this->container->getRoot()->get('services.option_manager');
        $form = new Form('fawd_likebutton');

        $likeButtonPostType = $om->load('options.' . $postType->name . '.like_button');
        $LikeButton = $likeButtonPostType->getLikeButton();

        $sections = array();
        $sections['default'] = $form->proccessFields('posttype_' . $postType->name, $likeButtonPostType->getFormConfig());
        $sections['options'] = $form->proccessFields('posttype_' . $postType->name, $LikeButton->getFormConfig());

        $success = $om->load('fawd_application_like_button_success_' . $postType->name);
        $om->save('fawd_application_like_button_success_' . $postType->name, false);

        $template = $this->container->getRootPath() . '/Resources/views/admin/settingsForm.html.php';
        echo $this->render($template, array(
            'postTypeName' => $postType->name,
            'sections' => $sections,
            'success' => $success
        ));
    }

    public function handlesSettingsSection()
    {
        $request = filter_input_array(INPUT_POST);
        //todo token verification
        if ($request) {
            foreach ($request as $key => $postTypeRequest) {
                if (is_array($postTypeRequest)) {
                    $likeButton = new LikeButton();
                    $likeButton->bind($postTypeRequest);
                    $likeButtonPostType = new LikeButtonPostType();
                    $likeButtonPostType->bind($postTypeRequest);
                    $likeButtonPostType->setLikeButton($likeButton);

                    $postTypeName = str_replace('fawd_likebutton_posttype_', '', $key);
                    $om = $this->container->getRoot()->get('services.option_manager');
                    $om->save('options.' . $postTypeName . '.like_button', $likeButtonPostType);
                    $om->save('fawd_application_like_button_success_' . $postTypeName, 'Settings were updated with success');

                    //set options like button post type as service.
                }
            }
        }
    }

}
