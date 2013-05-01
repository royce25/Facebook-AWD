<?php

/**
 *
 * @author alexhermann
 *
 */
$fields['commentsbox'] = array(
    'title_config' => array(
        'type' => 'html',
        'html' => '<h1>' . __('Configure the comments box', self::PTD) . '</h1>',
        'widget_no_display' => true
    ),
    'before_url' => array(
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
    'href' => array(
        'type' => 'text',
        'label' => __('Default Url', self::PTD),
        'class' => 'span4',
        'attr' => array('class' => 'span4')
    ),
    'after_url' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'before_config' => array(
        'type' => 'html',
        'html' => '<div class="row">'
    ),
    'type' => array(
        'type' => 'select',
        'options' => array(
            array('value' => 'xfbml', 'label' => __('Xfbml', self::PTD)),
            array('value' => 'html5', 'label' => __('html5', self::PTD)),
        ),
        'label' => __('Type', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'num_posts' => array(
        'type' => 'text',
        'label' => __('Nb of comments', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'order_by' => array(
        'type' => 'select',
        'options' => array(
            array('value' => 'social', 'label' => __('Social', self::PTD)),
            array('value' => 'reverse_time', 'label' => __('Reverse Time', self::PTD)),
            array('value' => 'time', 'label' => __('Time', self::PTD)),
        ),
        'label' => __('Order By', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'mobile' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Mobile version', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2')
    ),
    'after_config' => array(
        'type' => 'html',
        'html' => '</div>'
    ),
    'before_on_posts' => array(
        'type' => 'html',
        'html' => '<div class="row">',
        'widget_no_display' => true
    ),
    'on_pages' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Add Comments to pages', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2'),
        'widget_no_display' => true
    ),
    'on_posts' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Add Comments to posts', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2'),
        'widget_no_display' => true
    ),
    'on_custom_post_types' => array(
        'type' => 'select',
        'options' => array(
            array('value' => '0', 'label' => __('No', self::PTD)),
            array('value' => '1', 'label' => __('Yes', self::PTD)),
        ),
        'label' => __('Add Comments to custom posts', self::PTD),
        'class' => 'span2',
        'attr' => array('class' => 'span2'),
        'widget_no_display' => true
    ),
    'after_on_posts' => array(
        'type' => 'html',
        'html' => '</div>',
        'widget_no_display' => true
    ),
    'before_config2' => array(
        'type' => 'html',
        'html' => '<div class="row">'
    ),
    'place' => array(
        'type' => 'select',
        'options' => array(
            array('value' => 'before', 'label' => __('Before comments form', self::PTD)),
            array('value' => 'top', 'label' => __('Top of comments form', self::PTD)),
            array('value' => 'after', 'label' => __('After comments form', self::PTD)),
            array('value' => 'before_fields', 'label' => __('Before comments form fields', self::PTD)),
            array('value' => 'after_fields', 'label' => __('After comments form fields', self::PTD)),
            array('value' => 'replace', 'label' => __('Replace comments form', self::PTD))
        ),
        'label' => __('Where ?', self::PTD),
        'class' => 'span4',
        'attr' => array('class' => 'span4 commentsbox_place'),
        'widget_no_display' => true
    ),
    'comments_template_path' => array(
        'type' => 'text',
        'label' => __('Default comments template path (used only if replace is enabled)', self::PTD),
        'class' => 'span6',
        'attr' => array('class' => 'span6 depend_on_commentsbox_place')
    ),
    'exclude_post_id' => array(
        'type' => 'text',
        'label' => __('Exclude Posts or Pages ID (example: 12,46,234)', self::PTD),
        'class' => 'span4',
        'attr' => array('class' => 'span4'),
        'widget_no_display' => true
    ),
    'width' => array(
        'type' => 'text',
        'label' => __('Width', self::PTD),
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
    'after_config2' => array(
        'type' => 'html',
        'html' => '</div>',
    ),
    'link_manage' => array(
        'type' => 'html',
        'html' => ($this->options['app_id'] != '' ? '<a class="btn" target="_blank" href="https://developers.facebook.com/tools/comments?id=' . $this->options['app_id'] . '">' . __('Manage comments', self::PTD) . '</a>' : ''),
        'widget_no_display' => true
    ),
    'preview' => array(
        'type' => 'html',
        'html' => '
            <h1>' . __('Preview', self::PTD) . '</h1>
            <div class="well">' . do_shortcode('[AWD_facebook_commentsbox width="420"]') . '</div>
            <h1>' . __('Options List', self::PTD) . '</h1>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Option</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>url</td><td>string</td></tr>
                    <tr><td>width</td><td>number</td></tr>
                    <tr><td>num_posts</td><td>number</td></tr>
                    <tr><td>order_by</td><td>social, reverse_time, time</td></tr>
                    <tr><td>colorscheme</td><td>light or dark</td></tr>
                    <tr><td>mobile</td><td>0 or 1</td></tr>
                    <tr><td>type</td><td>xfbml or iframe or html5</td></tr>
                </tbody>
                <tfoot>
                        <tr><th colspan="2">[AWD_facebook_commentsbox option="value"]</th></tr>
                </tfoot>
            </table>',
        'widget_no_display' => true
    )
);
$fields['commentsbox'] = apply_filters("AWD_facebook_fields_commentsbox", $fields['commentsbox']);

?>