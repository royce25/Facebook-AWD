<?php

namespace AHWEBDEV\FacebookAWD\Extension\Controller;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\ContainerInterface;
use AHWEBDEV\Framework\Controller\Controller as BaseController;

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
 * @package FacebookAWD\Extension
 */
abstract class Controller extends BaseController
{
    /**
     *
     * @var FacebookAWD
     */
    protected $facebookAWD;

    /**
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->facebookAWD = $container->getFacebookAwd();
        parent::__construct($container);
    }
}

?>
