<?php

/**
 * Template
 *
 * @author alexhermann
 */
class AWD_facebook_template
{

    private $options;

    private $deps;

    private $templatePath;

    public $messages = array();

    public $errors = array();

    public $warnings = array();

    protected $AWD_facebook;

    public $helpTitle;

    public function __construct($AWD_facebook)
    {
        $this->AWD_facebook = $AWD_facebook;
        $this->options = $this->AWD_facebook->getOptions();
        $this->templatesPath = $this->options['templates_path'];
        $this->deps = $this->AWD_facebook->deps;
        $urlImages = $AWD_facebook->pluginImagesUrl;
        $this->helpTitle = '<div class=\'header_lightbox_help_title\'><img style=\'vertical-align:middle;\' src=\''.$urlImages.'facebook-mini.png\' alt=\'facebook logo\'/> '.__('Help',AWD_facebook::PTD).'</div></i>';
        $this->messages = array();
        $this->errors = array();
    }

    /**
     *
     * @param type $echo
     * @return type
     */
    public function displayNotices($echo = true)
    {
        $content = '';

        if (isset($this->errors) && count($this->errors) > 0 AND is_array($this->errors)) {
            $tmp = '';
            foreach ($this->errors as $error) {
                if (is_wp_error($error)) {
                    $tmp .= $error->get_error_message();
                }
            }
            $content .= $this->displayMessage($tmp, 'error', $echo);
        }


        if (isset($this->warnings) && count($this->warnings) > 0 AND is_array($this->warnings)) {
            $tmp = '';
            foreach ($this->warnings as $warning) {
                if (is_wp_error($warning))
                    $tmp .= $warning->get_error_message();
            }
            $content .= $this->displayMessage($tmp, 'warning', $echo);
        }



        if (isset($this->messages) && count($this->messages) > 0 AND is_array($this->messages)) {
            $tmp = '';
            foreach ($this->messages as $message) {
                if (is_wp_error($message))
                    $tmp .= $message->get_error_message();
                else
                    $tmp = $message;
            }
            $content .= $this->displayMessage($tmp, null, $echo);
        }

        if ($echo)
            echo $content;

        return $content;
    }

    /**
     *
     * @param type $message
     * @param type $type
     * @param type $echo
     * @return string
     */
    public function displayMessage($message = null, $type = 'info', $echo = true)
    {
        $content = '';
        $template = 'message.php';

        if (!empty($message)) {

            $params = array(
                'type' => $type,
                'content' => $message
            );
            $content = $this->render($template, $params, false);
        } else if (isset($this->messages) && count($this->messages) > 0 AND is_array($this->messages)) {

            foreach ($this->messages as $key => $message) {
                if (is_string($key))
                    $type = $key;
                $params = array(
                    'type' => $type,
                    'content' => $content
                );
                $content .= $this->render($template, $params, false);
            }
        }

        if (!$echo)
            return $content;

        echo $content;
    }

    /**
     * Will render a plugin based on the object or pluginSlug passed as param.
     *
     * @param string|object $plugin
     * @param array $options
     * @return string
     */
    public function renderPlugin($plugin, array $options)
    {
        try {
            if (is_string($plugin)) {
                $slug = str_replace('AWD_facebook_', '', $plugin);
                $options = wp_parse_args($options, $this->options[$slug]);
                $options = apply_filters('AWD_facebook_render_'.$slug, $options);
                $object = new $plugin($options);
            } else if (is_object($plugin)) {
                $object = $plugin;
            }
            //Always pass object
            $params = array('object' => $object, 'options' => $options);
            return $this->render($object->getTemplate(), $params, false);
        } catch (Exception $e) {
            return $this->displayMessage($e->getMessage(), 'error', false);
        }
    }

    /**
     *
     * @param array $options
     * @param string $content
     * @param string $tag
     * @return type
     */
    public function renderShortcode($options, $content = null, $tag)
    {
        if (!is_array($options))
            $options = array();
        return $this->renderPlugin($tag, $options);
    }

    /**
     *
     * @param type $template
     * @param type $params
     * @param type $echo
     * @return type
     */
    public function render($template, $params, $echo = true)
    {
        $path = locate_template('facebook-awd' . DIRECTORY_SEPARATOR . $template, false, false);
        if (empty($path))
            $path = $this->templatesPath . DIRECTORY_SEPARATOR . $template;

        extract($params);

        if (!$echo)
            ob_start();

        include($path);

        if (!$echo) {
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
    }

}

?>
