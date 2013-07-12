<?php

namespace AHWEBDEV\FacebookAWD\Provider\Standalone\Controller;

use AHWEBDEV\FacebookAWD\Extension\Controller\BackendController as BaseBackendController;

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
class BackendController extends BaseBackendController
{
    /**
     * The position of the menu in list
     * @var string
     */
    const MENU_POSITION = 6;

    /**
     * Init the admin
     */
    public function init()
    {
        $this->content();
    }

    /**
     * Base Admin content
     */
    public function content()
    {
        $menuItems = $this->getMenuItems();
        $template = dirname($this->facebookAWD->getFile()) . '/Resources/views/admin/index.html.php';
        echo parent::render($template, array('menuItems' => $menuItems));
    }

}

?>
