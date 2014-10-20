<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\FacebookAWD\Controller\AdminMenuController;
use AHWEBDEV\Framework\TemplateManager\Form;
use Exception;
use Facebook\Entities\FacebookApp;
use Facebook\Entities\FacebookRequest;

/**
 * This is the install controller
 *
 * This file will add some install step at first install of the plugin.
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class InstallController extends AdminMenuController
{

    /**
     * {@inheritdoc}
     */
    public function getMenuType()
    {
        return self::TYPE_MENU;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSlug()
    {
        return $this->container->getSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return $this->container->getTitle() . ' Setup';
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->setListenerResponse($this->handleInstall());

        //this will allow the plugin to display login under facebook plateform application tab and canvas
        //this is usually set by others plugins, but plugins are not registered when we are on install page.
        //So allow iframe embeded from here.
        remove_action('login_init', 'send_frame_options_header');
        remove_action('admin_init', 'send_frame_options_header');
    }

    /**
     * Install layout
     * @return string
     */
    public function index()
    {

        //if success
        if ($this->listenerResponse) {
            echo $this->listenerResponse;
            return;
        }

        $form = new Form('fawd');
        $application = $this->om->get('options.application');
        $options = $this->om->get('options');
        $formView = $form->processFields('application', $application->getFormConfig());
        $formView .= $form->processFields('options', $options->getFormConfig());
        $formView .= $form->processFields('token', $this->container->getTokenFormConfig());
        $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/install/install.html.php';
        $errors = $this->om->get('application_error');
        echo $this->render($template, array(
            'isReady' => $this->isReady(),
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
        $request = filter_input_array(INPUT_POST);
        $isTokenValid = isset($request['fawdtoken']) ? wp_verify_nonce($request['fawdtoken']['token'], 'fawd-token') : false;
        if ($isTokenValid) {
            try {
                //bind app data
                $application = $this->om->get('options.application');
                $application->bind($request['fawdapplication']);
                //bind options data
                $options = $this->om->get('options');
                $options->bind($request['fawdoptions']);


                $facebookApp = new FacebookApp($application->getId(), $application->getSecretKey());
                $facebookClient = $this->container->get('services.facebook.client');

                $request = new FacebookRequest($facebookApp, $facebookApp->getAccessToken(), 'GET', '/' . $application->getId());
                $response = $facebookClient->sendRequest($request);
                $applicationData = $response->getGraphObject()->asArray();
                $application->bind($applicationData);

                //save options
                $this->om->set('options.application', $application);
                $this->om->set('options', $options);
                $this->om->set('ready', true);
                $this->om->set('application_error', null);

                //set new instance
                $this->container->set('services.facebook.app', $facebookApp);

                $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/install/install-success.html.php';

                return $this->render($template, array(
                            'application' => $application
                ));
            } catch (Exception $e) {
                $this->om->set('application_error', $e->getMessage());
                $this->om->set('ready', false);

                return false;
            }
        }
    }

    /**
     * Return the HTML Install form
     * @param  array  $options
     * @return string
     */
    protected function installForm(array $options)
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
        return $this->container->get('services.option_manager')->get('ready');
    }

}
