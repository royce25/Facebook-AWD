<?php

namespace AHWEBDEV\Framework\TemplateManager;

use AHWEBDEV\Framework\ContainerInterface;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * TemplateManager
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
class TemplateManager
{

    protected $container;
    protected $options;
    protected $messages = array();
    protected $errors = array();
    protected $warnings = array();

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     *
     * @param  type   $message
     * @param  type   $type
     * @param  type   $echo
     * @return string
     */
    public function displayMessage($message, $type = 'info', $echo = true)
    {
        $template = 'message.php';

        $params = array(
            'type' => $type,
            'content' => $message
        );

        $content = $this->render($template, $params, false);

        if (!$echo)
            return $content;

        echo $content;
    }

    /**
     * Will render a plugin based on the object or pluginSlug passed as param.
     *
     * @param  string|object $plugin
     * @param  array         $options
     * @return string
     */
    /* public function renderPlugin($plugin, array $options)
      {
      try {
      if (is_string($plugin)) {
      $slug = str_replace('AWD_facebook_', '', $plugin);
      $options = wp_parse_args($options, $this->options[$slug]);
      $options = apply_filters('AWD_facebook_render_' . $slug, $options);
      $object = new $plugin($options);
      } elseif (is_object($plugin)) {
      $object = $plugin;
      }
      //Always pass object
      $params = array('object' => $object, 'options' => $options);

      return $this->render($object->getTemplate(), $params, false);
      } catch (Exception $e) {
      return $this->displayMessage($e->getMessage(), 'error', false);
      }
      } */

    /**
     *
     * @param  array  $options
     * @param  string $content
     * @param  string $tag
     * @return type
     */
    /* public function renderShortcode($options, $content = null, $tag)
      {
      if (!is_array($options))
      $options = array();

      return $this->renderPlugin($tag, $options);
      } */

    /**
     *
     * @param  type $template
     * @param  type $params
     * @param  type $echo
     * @return type
     */
    public function render($template, $params = array(), $echo = true)
    {
        extract($params);

        if (!$echo)
            ob_start();

        include($template);

        if (!$echo) {
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }
    }

    /**
     *
     * Getter
     * the first image displayed in a post.
     * @param  string $post_content
     * @return the    image found.
     */
    public function catchFisrtImage($postContent)
    {
        $firstImg = '';
        $matches = array();

        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $postContent, $matches);
        if (isset($matches[1][0]))
            $firstImg = $matches[1][0];

        return $firstImg;
    }

    /**
     * Return All messages
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set all messages
     * @param array $messages
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Add a message in the set of alert
     * @param string $type
     * @param string $message
     */
    public function addMessage($type, $message)
    {
        $this->messages[$type] = $message;
    }
    
    
    /**
     * Translate in template
     * @param type $string
     * @return type
     */
    public function __($string){
        return __($string, $this->container->getPtd());
    }
    
    /**
     * Echo & Translate in template
     * @param type $string
     */
    public function _e($string){
        echo $this->__($string);
    }
}
