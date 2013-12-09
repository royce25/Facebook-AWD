<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\Framework\Controller\Controller;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * InstallController
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD\Extension\Wordpress
 */
class HomeController extends Controller
{
    public function home()
    {
        $template = dirname($this->container->getFile()) . '/Resources/views/admin/home.html.php';
        return $this->render($template, array(
            'application' => $this->container->get('services.application')
        ));
    }
}

?>
