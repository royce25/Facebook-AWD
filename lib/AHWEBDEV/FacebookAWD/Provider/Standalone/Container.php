<?php

namespace AHWEBDEV\FacebookAWD\Provider\Standalone;

use AHWEBDEV\FacebookAWD\Provider\Standalone\Controller\BackendController;
use AHWEBDEV\FacebookAWD\Extension\Container as BaseContainer;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extension
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD\Extension\Wordpress
 */
class Container extends BaseContainer
{

    /**
     * Init
     */
    public function init()
    {
        $this->launch();
    }

    /**
     * Launch the extension and add functionnality to wprdoress hook
     */
    public function launch()
    {
        $this->setBackendController(new BackendController($this));
    }

}

?>
