<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeButton\Controller;

use AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButton;
use AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButtonPostType;
use AHWEBDEV\Framework\TemplateManager\Form;
use AHWEBDEV\Wordpress\Admin\MetaboxInterface;
use AHWEBDEV\Wordpress\Controller\AdminMenuController as BaseController;
use RuntimeException;

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
            add_meta_box($pageHook . '_likebutton_posttype_' . $postType->name . '_settings', $postType->labels->name, array($this, 'settingsBoxes'), $pageHook, 'normal', 'default', array($postType));
        }
    }

    /**
     * Init the controller
     * Add an wordpress action to create the admin menu/submenu page
     */
    public function init()
    {
        parent::init();
        add_action('wp_ajax_save_likebutton_settings', array($this, 'handlesSettingsSection'));

        //assets configurations
        $publicUrl = plugins_url(null, __DIR__) . '/Resources/public/';
        $assets = $this->container->getRoot()->getAssets();
        $assets['script'][$this->container->getSlug() . '-admin-js'] = $publicUrl . 'js/admin.js';
        $this->container->getRoot()->setAssets($assets);
        
        //we need a hook here to add the add style/script pages !
        wp_enqueue_script($this->container->getSlug() . '-admin-js');
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

    /**
     * 
     * @param $postType
     * @return string
     */
    public function settingsSection($postType)
    {
        $om = $this->container->getRoot()->get('services.option_manager');
        $form = new Form('fawd_likebutton');

        $likeButtonPostType = $om->load('options.' . $postType->name . '.like_button');
        $likeButton = $likeButtonPostType->getLikeButton();

        $sections = array();
        $sections['default'] = $form->proccessFields('posttype_' . $postType->name, $likeButtonPostType->getFormConfig());
        $sections['options'] = $form->proccessFields('posttype_' . $postType->name, $likeButton->getFormConfig());
        $token = array(
            'token' => array(
                'name' => 'token',
                'type' => 'hidden',
                'attr' => null,
                'group' => false,
                'value' => wp_create_nonce('fawd-token')
            )
        );
        $sections['security'] = $form->proccessFields('posttype_' . $postType->name, $token);

        $success = $om->load('fawd_application_like_button_success_' . $postType->name);
        $om->save('fawd_application_like_button_success_' . $postType->name, false);

        $template = $this->container->getRootPath() . '/Resources/views/admin/settingsForm.html.php';
        return $this->render($template, array(
                    'postTypeName' => $postType->name,
                    'sections' => $sections,
                    'success' => $success
        ));
    }

    /**
     * Wrap a section into metaboes
     * @param $post
     * @param array $metaboxData
     * @throws RuntimeException
     */
    public function settingsBoxes($post, array $metaboxData)
    {
        $isValidPostType = isset($metaboxData['args'][0]) && is_object($metaboxData['args'][0]);
        if (!$isValidPostType) {
            throw new RuntimeException('The settingsBoxes methods requires $metaboxData[0] = $postType');
        }
        echo $this->settingsSection($metaboxData['args'][0]);
    }

    /**
     * 
     */
    public function handlesSettingsSection()
    {
        $request = filter_input_array(INPUT_POST);
        if ($request) {
            foreach ($request as $key => $postTypeRequest) {
                if (is_array($postTypeRequest)) {
                    $isTokenValid = wp_verify_nonce($postTypeRequest['token'], 'fawd-token');
                    if ($isTokenValid) {
                        $likeButton = new LikeButton();
                        $likeButton->bind($postTypeRequest);
                        $likeButtonPostType = new LikeButtonPostType();
                        $likeButtonPostType->bind($postTypeRequest);
                        $likeButtonPostType->setLikeButton($likeButton);

                        $postTypeName = str_replace('fawd_likebutton_posttype_', '', $key);
                        $om = $this->container->getRoot()->get('services.option_manager');
                        $om->save('options.' . $postTypeName . '.like_button', $likeButtonPostType);
                        $om->save('fawd_application_like_button_success_' . $postTypeName, 'Settings were updated with success');

                        if ($this->isAjaxRequest()) {
                            $template = $this->container->getRoot()->getRootPath() . '/Resources/views/ajax/ajax.json.php';
                            echo $this->render($template, array(
                                'postTypeName' => $postTypeName,
                                'section' => $this->settingsSection(get_post_type_object($postTypeName))
                            ));
                            exit;
                        }
                    }
                }
            }
        }
    }

}
