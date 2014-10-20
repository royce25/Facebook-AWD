<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\Controller\Controller as BaseController;
use AHWEBDEV\Wordpress\OptionManager\OptionManager;

/**
 * FacebookAWD FrontController
 *
 * This file is the front controller
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
abstract Class Controller extends BaseController
{
    /**
     *
     * @var OptionManager 
     */
    protected $om;

    /**
     * 
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->om = $container->getRoot()->get('services.option_manager');
    }
}
