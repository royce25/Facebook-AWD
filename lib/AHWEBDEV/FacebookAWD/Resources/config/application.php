<?php

/**
 * Model form fields definition
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
$fields['application'] = array(
    'id' => array(
        'type' => 'text',
        'label' => __('Identifier', self::PTD),
        'class' => 'form-group',
        'attr' => array('class' => 'form-control')
    ),
    'secret_key' => array(
        'type' => 'text',
        'label' => __('Secret Key', self::PTD),
        'class' => 'form-group',
        'attr' => array('class' => 'form-control')
    )
);
$fields['activitybox'] = apply_filters("AWD_facebook_fields_activitybox", $fields['activitybox']);
?>