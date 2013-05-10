<?php

/**
 * Model form fields definition
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
$fields['loginbutton'] = array(
    'title_config' => array(
        'type' => 'html',
        'html' => '<h1>' . __('Configure the button', self::PTD) . '</h1>',
        'widget_no_display' => true
    ),
    'start_config' => array(
        'type' => 'html',
        'html' => '<div class="row">'
    ),
    'widget_title' => array(
        'type' => 'text',
        'label' => __('Title', self::PTD),
        'class' => 'span4',
        'attr' => array('class' => 'span4'),
        'widget_only' => true
    ),
    'display_on_login_page' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Display on Login', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2'),
        'widget_no_display' => true
    ),
    'display_on_register_page' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Display on Register', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2'),
        'widget_no_display' => true
    ),
    'login_redirect_url' => array(
        'type' => 'text',
        'label' => __('Url after login', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'logout_redirect_url' => array(
        'type' => 'text',
        'label' => __('Url after logout', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'logout_label' => array(
        'type' => 'text',
        'label' => __('Logout Label', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'show_profile_picture' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Show profile picture', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'show_faces' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Show faces', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2 loginbutton_show_faces')
    ),
    'maxrow' => array(
        'type' => 'text',
        'label' => __('Max row', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2 depend_loginbutton_show_faces', 'disabled' => ($this->options['loginbutton']['show_faces'] == "0" ? 'disabled' : ''))
    ),
    'width' => array(
        'type' => 'text',
        'label' => __('Width of button', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'image' => array(
        'type' => 'media',
        'label' => __('Button Image', self::PTD),
        'class' => 'span8',
        'attr' => array('class' => 'span6')
    ),
    'end_config' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'preview' => array(
        'type' => 'html',
        'html' => '
            <h1>' . __('Preview', self::PTD) . '</h1>
            <div class="well">' . do_shortcode('[AWD_facebook_loginbutton]') . '</div>
            <h1>' . __('Options List', self::PTD) . '</h1>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Option</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>profile_picture</td><td>0 or 1</td></tr>
                    <tr><td>faces</td><td>0 or 1</td></tr>
                    <tr><td>maxrow</td><td>number (only if faces = 1)</td></tr>
                    <tr><td>login_url</td><td>string</td></tr>
                    <tr><td>logoutUrl</td><td>string</td></tr>
                    <tr><td>width</td><td>number</td></tr>
                    <tr><td>image</td><td>url</td></tr>
                </tbody>
                <tfoot>
                    <tr><th colspan="2">[AWD_facebook_loginbutton option="value"]</th></tr>
                </tfoot>
            </table>',
        'widget_no_display' => true
    )
);
$fields['loginbutton'] = apply_filters("AWD_facebook_fields_loginbutton", $fields['loginbutton']);

?>