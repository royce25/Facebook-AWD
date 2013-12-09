<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\FacebookAWD\Api\Api;
use AHWEBDEV\Framework\Controller\Controller;
use AHWEBDEV\Framework\TemplateManager\Form;
use Exception;

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
class InstallController extends Controller
{

    /**
     * Init the admin
     */
    public function init()
    {
        return $this;
    }

    public function install()
    {
        $response = $this->handleInstall();
        if ($response) {
            echo $response;
            return;
        }
        $form = new Form('fawd', 'POST', '', 'fawd_install');
        $om = $this->container->get('services.option_manager');
        $application = $this->container->get('services.application');
        //print_r($application);
        $formView = $form->proccessFields('application', $application->getFormConfig());
        $template = dirname($this->container->getFile()) . '/Resources/views/admin/install.html.php';
        $error = $om->load('fawd_application_error');
        echo parent::render($template, array(
            'form' => $form,
            'formView' => $formView,
            'application' => $application,
            'error' => $error
        ));
        return;
    }

    public function isReady()
    {
        return $this->container->get('services.option_manager')->load('fawd_ready');
    }

    public function updateInstall()
    {
        $facebook = $this->container->get('services.api');
        $om = $this->container->get('services.option_manager');
        $application = $this->container->get('services.application');
        $valid = true;
        try {
            $appInfos = $facebook->api('/' . $facebook->getAppId());

            $application->bind($appInfos);
            $om->save('options.application', $application);
            $this->container->set('services.application', $application);

            $om->save('fawd_ready', true);
            $om->save('fawd_application_error', null);
        } catch (Exception $e) {
            $valid = false;
            $om->save('fawd_application_error', $e->getMessage());
            $om->save('fawd_ready', false);
        }
        return $valid;
    }

    public function handleInstall()
    {
        $token = isset($_POST['fawd_application']['token']) ? $_POST['fawd_application']['token'] : null;
        if ($token && wp_verify_nonce($token, 'fawd-token')) {
            unset($_POST['fawd_application']['token']);

            $application = $this->container->get('services.application');
            $application->bind($_POST['fawd_application']);
            $api = new Api($application);
            $this->container->set('services.api', $api);

            //check the install using the api
            if ($this->updateInstall()) {
                $template = dirname($this->container->getFile()) . '/Resources/views/admin/install-success.html.php';
                return $this->render($template, array(
                            'application' => $application
                ));
            } else {
                return false;
            }
        }
    }

}

?>
