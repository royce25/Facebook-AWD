<?php

namespace AHWEBDEV\Wordpress\Controller;

use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\Controller\Controller;
use AHWEBDEV\Wordpress\Admin\AdminInterface;
use AHWEBDEV\Wordpress\Admin\AdminMenuControllerInterface;
use AHWEBDEV\Wordpress\Admin\AdminMenuInterface;
use AHWEBDEV\Wordpress\Admin\MetaboxInterface;
use RuntimeException;

/*
 * This file is part of AWD Wordpress.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * AdminController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 */
abstract class AdminMenuController extends Controller implements AdminMenuControllerInterface
{

    const TYPE_MENU = 0;
    const TYPE_SUBMENU = 1;

    /**
     *
     * @var AdminInterface
     */
    protected $admin;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     * @param AdminInterface     $admin
     */
    public function __construct(ContainerInterface $container, AdminInterface $admin)
    {
        parent::__construct($container);
        $this->admin = $admin;
    }

    /**
     * Init the controller
     * Add an wordpress action to create the admin menu/submenu page
     */
    public function init()
    {
        //init the admin menu if required
        if ($this instanceof AdminMenuControllerInterface) {
            add_action('admin_menu', array($this, 'adminMenu'), 11);
        }
    }

    /**
     * Create the admin menu and attach it to the backend controller.
     * @return string $pageHook
     */
    public function adminMenu()
    {
        $menuSlug = $this->getMenuSlug();
        $parentSlug = $this->container->getSlug();
        $menuTitle = $this->getMenuTitle();
        $capability = 'manage_options';

        if ($this->getMenuType() === self::TYPE_MENU) {
            $pageHook = add_menu_page($menuTitle, $menuTitle, $capability, $menuSlug, array($this, 'index'));
        } elseif ($this->getMenuType() === self::TYPE_SUBMENU) {
            $pageHook = add_submenu_page($menuSlug, $parentSlug, $menuTitle, $capability, $parentSlug, array($this, 'index'));
        } else {
            throw new RuntimeException('The method getMenuType in controller must return a valid response into menu and submenu');
        }

        $this->admin->addAdminMenuHook($parentSlug, $pageHook);

        if ($this instanceof MetaboxInterface) {
            $this->addMetaboxes($pageHook);
            //add_screen_option('layout_columns', array('max' => 2, 'default' => 1));
        }
    }

    /**
     * @see AdminMenuInterface
     */
    abstract public function getMenuSlug();

    /**
     * @see AdminMenuInterface
     */
    abstract public function getMenuTitle();

    /**
     * @see AdminMenuInterface
     */
    abstract public function getMenuType();
}
