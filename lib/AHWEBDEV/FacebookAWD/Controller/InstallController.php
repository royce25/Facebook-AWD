<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\FacebookAWD\Api\Api;
use AHWEBDEV\Framework\Controller\Controller;
use AHWEBDEV\Framework\TemplateManager\Form;

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
     * Install layout
     * @return string
     */
    public function index()
    {
        $response = $this->handleInstall();
        if ($response) {
            echo $response;
            return;
        }
        $form = new Form('fawd', 'POST', '', 'fawd_install');
        $om = $this->container->get('services.option_manager');
        $application = $this->container->get('services.application');

        $formView = $form->proccessFields('application', $application->getFormConfig());
        $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/install/install.html.php';
        $errors = $om->load('fawd_application_error');

        echo $this->render($template, array(
            'title' => __('Setup', $this->container->getPtd()),
            'application' => $application,
            'formContent' => $this->installForm(array(
                'form' => $form,
                'formView' => $formView,
                'errors' => $errors
            ))
        ));
        return;
    }

    /**
     * Handle the install
     * @return boolean
     */
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
                $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/install/install-success.html.php';

                return $this->render($template, array(
                            'application' => $application
                ));
            } else {
                return false;
            }
        }
    }

    /**
     * Check and save the data in DB
     * @return boolean
     */
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
        } catch (\Exception $e) {
            $valid = false;
            $om->save('fawd_application_error', $e->getMessage());
            $om->save('fawd_ready', false);
        }

        return $valid;
    }

    /**
     * Return the HTML Install form
     * @param array $options
     * @return type
     */
    public function installForm(array $options)
    {
        $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/install/installForm.html.php';
        return $this->render($template, $options);
    }

    /**
     * Check if the plugin is ready
     * @return boolean
     */
    public function isReady()
    {
        return $this->container->get('services.option_manager')->load('fawd_ready');
    }

}
