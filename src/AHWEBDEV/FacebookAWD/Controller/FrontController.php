<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\Framework\Controller\Controller as BaseController;

/**
 * FacebookAWD FrontController
 *
 * This file is the front controller
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class FrontController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        //add scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
    }

    /**
     * Enqueue assets
     */
    public function enqueueStyles()
    {
        $this->container->getRoot()->registerAssets();
        wp_enqueue_style($this->container->getSlug().'bootstrap');
    }

}
