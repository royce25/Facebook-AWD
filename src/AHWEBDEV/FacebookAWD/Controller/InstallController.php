<?php

namespace AHWEBDEV\FacebookAWD\Controller;

use AHWEBDEV\FacebookAWD\Api\Api;
use AHWEBDEV\Framework\TemplateManager\Form;
use AHWEBDEV\Wordpress\Controller\AdminMenuController;
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
class InstallController extends AdminMenuController
{

    /**
     *
     * @return string
     */
    public function getMenuType()
    {
        return self::TYPE_MENU;
    }

    /**
     *
     * @return string
     */
    public function getMenuSlug()
    {
        return $this->container->getSlug();
    }

    /**
     *
     * @return string
     */
    public function getMenuTitle()
    {
        return $this->container->getTitle() . ' Setup';
    }

    /**
     * Init the admin
     * Listen for install post
     */
    public function init()
    {
        parent::init();
        $this->setListenerResponse($this->handleInstall());
    }

    /**
     * Install layout
     * @return string
     */
    public function index()
    {

        if ($this->listenerResponse) {
            echo $this->listenerResponse;
            return;
        }
        $form = new Form('fawd');
        $om = $this->container->get('services.option_manager');
        $application = $this->container->get('services.application');
        $options = $this->container->get('services.options');
        $token = array(
            'token' => array(
                'name' => 'token',
                'type' => 'hidden',
                'attr' => null,
                'group' => false,
                'value' => wp_create_nonce('fawd-token')
            )
        );
        $formView = $form->proccessFields('application', $application->getFormConfig());
        $formView .= $form->proccessFields('options', $options->getFormConfig());
        $formView .= $form->proccessFields('token', $token);
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
        $request = filter_input_array(INPUT_POST);
        $isTokenValid = isset($request['fawd_token']) ? wp_verify_nonce($request['fawd_token']['token'], 'fawd-token') : false;
        if ($isTokenValid) {
            $om = $this->container->get('services.option_manager');
            try {
                //bind app data
                $application = $this->container->get('services.application');
                $application->bind($request['fawd_application']);
                //bind options data
                $options = $this->container->get('services.options');
                $options->bind($request['fawd_options']);
                //instaciate a new facebook sdk
                $facebook = new Api($application);
                $appInfos = $facebook->api('/' . $facebook->getAppId());
                $application->bind($appInfos);

                //save options                
                $om->save('options.application', $application);
                $om->save('options', $options);
                $om->save('fawd_ready', true);
                $om->save('fawd_application_error', null);

                //set new instance
                $this->container->set('services.application', $application);
                $this->container->set('services.options', $options);
                $this->container->set('services.api', $facebook);

                //delete memory cache 
                //will be regenrated at next request.
                $this->container->store(true);

                $template = $this->container->getRoot()->getRootPath() . '/Resources/views/admin/install/install-success.html.php';
                return $this->render($template, array(
                            'application' => $application
                ));
            } catch (Exception $e) {
                $om->save('fawd_application_error', $e->getMessage());
                $om->save('fawd_ready', false);
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
        return $this->container->get('services.option_manager')->load('fawd_ready');
    }

}
