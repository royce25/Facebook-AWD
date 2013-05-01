<?php

/**
 *
 * @author alexhermann
 *
 */
$fields['activitybox'] = array(
    'title_config' => array(
        'type' => 'html',
        'html' => '<h1>' . __('Configure the box', self::PTD) . '</h1>',
        'widget_no_display' => true
    ),
    'start_domain' => array(
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
    'domain' => array(
        'type' => 'text',
        'label' => __('Domain', self::PTD),
        'class' => 'span4',
        'attr' => array('class' => 'span4')
    ),
    'end_domain' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'start_config' => array(
        'type' => 'html',
        'html' => '<div class="row">'
    ),
    'type' => array(
        'type' => 'select',
        'options' => array(
            array('value' => 'iframe', 'label' => __('Iframe', self::PTD)),
            array('value' => 'xfbml', 'label' => __('Xfbml', self::PTD)),
            array('value' => 'html5', 'label' => __('html5', self::PTD)),
        ),
        'label' => __('Type', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'filter' => array(
        'type' => 'text',
        'label' => __('Filter', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'ref' => array(
        'type' => 'text',
        'label' => __('Ref', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'max_age' => array(
        'type' => 'text',
        'label' => __('Max Age', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'linktarget' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '_blank', 'label' => __('Blank', self::PTD)),
            array('value' => '_top', 'label' => __('Top', self::PTD)),
            array('value' => '_parent', 'label' => __('Parent', self::PTD)),
        ),
        'label' => __('Links Target', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'width' => array(
        'type' => 'text',
        'label' => __('Width of box', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'height' => array(
        'type' => 'text',
        'label' => __('Height of box', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'header' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Show Header ?', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'recommendations' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Recommendations', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'colorscheme' => array(
        'type' => 'select',
        'options' => array(
            array('value' => 'light', 'label' => __('light', self::PTD)),
            array('value' => 'dark', 'label' => __('Dark', self::PTD)),
        ),
        'label' => __('Colors', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'font' => array(
        'type' => 'select',
        'options' => array(
            array('value' => 'arial', 'label' => __('Arial', self::PTD)),
            array('value' => 'lucida grande', 'label' => __('Lucida grande', self::PTD)),
            array('value' => 'segoe ui', 'label' => __('Segoe ui', self::PTD)),
            array('value' => 'tahoma', 'label' => __('Tahoma', self::PTD)),
            array('value' => 'trebuchet ms', 'label' => __('Trebuchet ms', self::PTD)),
            array('value' => 'verdana', 'label' => __('Verdana', self::PTD))
        ),
        'label' => __('Fonts', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'border_color' => array(
        'type' => 'text',
        'label' => __('Border color', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'end_config' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'preview' => array(
        'type' => 'html',
        'html' => '
            <h1>' . __('Preview', self::PTD) . '</h1>
            <div class="well">' . do_shortcode('[AWD_facebook_activitybox]') . '</div>
            <h1>' . __('Options List', self::PTD) . '</h1>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Option</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>domain</td><td>string</td></tr>
                    <tr><td>width</td><td>number</td></tr>
                    <tr><td>height</td><td>number</td></tr>
                    <tr><td>colorscheme</td><td>light or dark</td></tr>
                    <tr><td>fonts</td><td>string</td></tr>
                    <tr><td>border_color</td><td>hexadecimal string (ex: #ffffff for white)</td></tr>
                    <tr><td>recommendations</td><td>0 or 1</td></tr>
                    <tr><td>header</td><td>0 or 1</td></tr>
                    <tr><td>type</td><td>xfbml or iframe or html5</td></tr>
                    <tr><td>max_age</td><td>string</td></tr>
                    <tr><td>ref</td><td>string</td></tr>
                    <tr><td>linktarget</td><td>_blank or _top or _parent</td></tr>
                    <tr><td>filter</td><td>string</td></tr>
                </tbody>
                <tfoot>
                    <tr><th colspan="2">[AWD_facebook_activitybox option="value"]</th></tr>
                </tfoot>
            </table>',
        'widget_no_display' => true
    )
);
$fields['activitybox'] = apply_filters("AWD_facebook_fields_activitybox", $fields['activitybox']);
?>