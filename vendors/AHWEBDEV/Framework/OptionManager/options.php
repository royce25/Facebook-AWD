<?php
/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Options
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
return array(
    'application' => array(
        'app_id' => null,
        'app_secret' => null,
        'app_infos' => null,
        'locale' => 'en_US'
    ),
    'api' => array(
        'scope' => 'email',
        'use_avatar' => false,
        'timeout' => 10,
        'curl_options' => array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->options['timeout'],
            CURLOPT_USERAGENT => 'facebook-php-3.2',
            CURLOPT_SSL_VERIFYPEER => 0
        )
    ),
    'publisher' => array(
        'on_page' => false,
        'on_timeline' => false,
        'message' => null,
        'readmore' => null
    ),
    /* 'opengraph' => array(
      'objects' => array(),
      'object_relations' => array(),
      'contexts' => array()
      ), */
);

/*

  //Plugins options
  $likebutton = array
  (
  'href' => home_url(),
  'send' => 0,
  'width' => 300,
  'height' => 35,
  'colorscheme' => 'light',
  'show_faces' => 0,
  'font' => 'arial',
  'action' => 'like',
  'layout' => 'standard',
  'type' => 'html5',
  'ref' => '',
  'on_pages' => 0,
  'place_on_pages' => 'top',
  'on_posts' => 0,
  'place_on_posts' => 'top',
  'on_custom_post_types' => 0,
  'place_on_custom_post_types' => 'top',
  'exclude_post_type' => '',
  'exclude_terms_slug' => '',
  'exclude_post_id' => ''
  );
  $this->setDefaultValue('likebutton', $likebutton);

  $likebox = array
  (
  'href' => home_url(),
  'width' => 292,
  'height' => 300,
  'colorscheme' => 'light',
  'show_faces' => 0,
  'stream' => 0,
  'type' => 'html5',
  'border_color' => '',
  'force_wall' => '',
  'header' => 0
  );
  $this->setDefaultValue('likebox', $likebox);

  $url = parse_url(home_url());
  $activitybox = array
  (
  'domain' => $url['host'],
  'width' => 292,
  'height' => 300,
  'colorscheme' => 'light',
  'font' => 'arial',
  'show_faces' => 0,
  'type' => 'html5',
  'border_color' => '',
  'recommendations' => 0,
  'header' => 0,
  'filter' => '',
  'linktarget' => '_blank',
  'ref' => '',
  'max_age' => '',
  );
  $this->setDefaultValue('activitybox', $activitybox);

  $shared_activitybox = array
  (
  'width' => 292,
  'height' => 300,
  'font' => 'arial'
  );
  $this->setDefaultValue('shared_activitybox', $shared_activitybox);

  $loginbutton = array
  (
  'display_on_login_page' => 0,
  'display_on_register_page' => 0,
  'login_redirect_url' => '',
  'logout_redirect_url' => '',
  'logout_label' => __('Logout', $AWD_facebook::PTD),
  'show_profile_picture' => 1,
  'show_faces' => 0,
  'maxrow' => 1,
  'width' => 200,
  'image' => $AWD_facebook->pluginImagesUrl . 'f-connect.png'
  );
  $this->setDefaultValue('loginbutton', $loginbutton);

  $commentsbox = array
  (
  'href' => home_url(),
  'colorscheme' => 'light',
  'width' => 500,
  'num_posts' => 10,
  'type' => 'html5',
  'mobile' => 0,
  'on_pages' => 0,
  'on_posts' => 0,
  'on_custom_post_types' => 0,
  'exclude_post_id' => '',
  'order_by' => 'social',
  'place' => 'after',
  'comments_template_path' => dirname(dirname(dirname(__FILE__))) . '/views/default_comments.php'
  );
  $this->setDefaultValue('commentsbox', $commentsbox);

  $this->setDefaultValue('content_manager', array(
  'likebutton' => array(
  'redefine' => 0,
  'enabled' => 1,
  'place' => 'top'
  ),

  $this->options['curl_options'] = array(
  CURLOPT_CONNECTTIMEOUT => 10,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => $this->options['timeout'],
  CURLOPT_USERAGENT => 'facebook-php-3.2',
  CURLOPT_SSL_VERIFYPEER => 0
  );
 */
