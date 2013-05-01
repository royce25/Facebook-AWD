<?php

/**
 *
 * @author alexhermann
 *
 */
$fields['shared_activitybox'] = array(
    'title_config' => array(
        'type' => 'html',
        'html' => '<h1>' . __('Configure the box', self::PTD) . '</h1>',
        'widget_no_display' => true
    ),
    'start_title' => array(
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
    'end_title' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'start_config' => array(
        'type' => 'html',
        'html' => '<div class="row">'
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
    'end_config' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'preview' => array(
        'type' => 'html',
        'html' => '
            <h1>' . __('Preview', self::PTD) . '</h1>
            <div class="well">' . do_shortcode('[AWD_facebook_shared_activitybox]') . '</div>
            <h1>' . __('Options List', self::PTD) . '</h1>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Option</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>width</td><td>number</td></tr>
                    <tr><td>height</td><td>number</td></tr>
                    <tr><td>fonts</td><td>string</td></tr>
                </tbody>
                <tfoot>
                    <tr><th colspan="2">[AWD_facebook_shared_activitybox option="value"]</th></tr>
                </tfoot>
            </table>
		',
        'widget_no_display' => true
    )
);
$fields['shared_activitybox'] = apply_filters("AWD_facebook_fields_shared_activitybox", $fields['shared_activitybox']);

?>