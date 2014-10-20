<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Wordpress\Admin\AdminInterface;
use AHWEBDEV\Wordpress\Controller\AdminMenuController as BaseController;
use AHWEBDEV\Wordpress\OptionManager\OptionManager;

/**
 * This is the admin controller
 *
 * This file add required hooks in wordpress admin using
 * controllers and models
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
abstract Class AdminMenuController extends BaseController
{

    /**
     *
     * @var OptionManager 
     */
    protected $om;

    /**
     * 
     * @param ContainerInterface $container
     * @param AdminInterface $admin
     */
    public function __construct(ContainerInterface $container, AdminInterface $admin)
    {
        parent::__construct($container, $admin);
        $this->om = $container->getRoot()->get('services.option_manager');
    }

}
