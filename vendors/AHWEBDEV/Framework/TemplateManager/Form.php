<?php

namespace AHWEBDEV\Framework\TemplateManager;

use RuntimeException;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Form
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
class Form
{

    /**
     *
     * @var string 
     */
    protected $id;

    /**
     *
     * @var array 
     */
    protected $defaultOptions;

    //protected $widget;

    /**
     * 
     * @param type $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        $this->defaultOptions = array(
            'label_attr' => array('class' => 'control-label'),
            'label_after' => false,
            'label' => false,
            'help' => false,
            'type' => false,
            'group' => true,
            'class' => 'form-group',
            'attr' => array('class' => 'form-control')
        );
        /* if ($this->isWidget($this->id)) {
          $this->id = null;
          $this->widget = $id;
          } */
    }

    public function getMappingsTypes()
    {
        return array(
            'text' => 'createInputText',
            'hidden' => 'createInputHidden',
            'select' => 'createSelect',
            'checkbox' => 'createInputCheckBox'
        );
    }

    public function getMethodByType($type)
    {
        $types = $this->getMappingsTypes();
        if (!isset($types[$type])) {
            throw new RuntimeException('The type ' . $type . ' does not exist in form mapping');
        }
        return $types[$type];
    }

    /**
     * 
     * @param array $config
     * @return string
     */
    public function createInputHidden($config)
    {
        $inputText = $this->createInputText($config);
        $html = str_ireplace('type="text"', 'type="hidden"', $inputText);
        return $html;
    }

    /**
     * Create an html input Text
     * @param array $config
     * @return string
     */
    public function createInputText($config)
    {
        $config = $this->mergeOptions($config);
        $id = sanitize_key($config['name']);

//        $html = '<div class="' . $config['class'] . '">';

        /* if ($prepend != '' OR $append) {
          $html .= '<div class="' . ($append != '' ? 'input-append' : '') . ' ' . ($prepend != '' ? 'input-prepend' : '') . ' ">';
          }

          if ($prepend != '') {
          $html .= '<span class="add-on"><i class="' . $prepend . '"></i></span>';
          } */
        $html = '<input type="text" id="' . $id . '" name="' . $config['name'] . '" value="' . $config['value'] . '" ' . $this->processAttr($config['attr']) . ' />';

        /* if ($append != '') {
          $html .= $append;
          }

          if ($prepend OR $append) {
          $html .= '</div>';
          } */

        return $html;
    }

    public function createInputCheckBox($config)
    {
        $inputText = $this->createInputText($config);
        $html = str_ireplace('type="text"', 'type="checkbox"', $inputText);
        return $html;
    }

    public function addInputTextArea($label, $id, $value, $class = '', $attrs = array())
    {
        $field_id = sanitize_key($id);
        $html = '
            <div class="' . $class . '">
                <label for="' . $field_id . '">' . $label . '</label>
                <textarea id="' . $field_id . '" name="' . $this->prefix . $id . '" ' . $this->processAttr($attrs) . '>' . $value . '</textarea>
            </div>';

        return $html;
    }

    public function createSelect($config)
    {
        $config = $this->mergeOptions($config);
        $id = sanitize_key($config['name']);

        $html = '<select id="' . $id . '" name="' . $config['name'] . '" ';
        $html .= $this->processAttr($config['attr']);
        $html .= '>';
        foreach ($config['options'] as $option => $info) {
            $html .='<option value="' . $info['value'] . '" ' . ($info['value'] == $config['value'] ? 'selected="selected"' : '') . ' >' . $info['label'] . '</option>';
        }
        $html .='</select>';
        return $html;
    }

    protected function processAttr($attrs)
    {
        $html = '';
        if (is_array($attrs) && count($attrs)) {
            foreach ($attrs as $attr => $value) {
                if ($value != '') {
                    $html .= $attr . '="' . $value . '" ';
                }
            }
        }

        return $html;
    }

    /**
     * Merge form config with default options
     */
    public function mergeOptions(array $config)
    {
        return array_merge($this->defaultOptions, $config);
    }

    /* public function addMediaButton($label, $id, $value, $class = '', $attrs = array(), $datas = array('data-title' => 'Upload Media', 'data-type' => 'image'), $rm = false)
      {
      $fieldId = sanitize_key($id);
      $html ='<div class="input-append">
      <input type="text" id="' . $field_id . '" name="' . $this->prefix . $id . '" value="' . $value . '" ' . $this->processAttr($attrs) . ' />
      <button class="btn AWD_button_media" type="button" ' . $this->processAttr($datas) . ' data-field="' . $field_id . '"><i class="icon-upload"></i></button>';
      if ($rm == true) {
      $html .='<button class="btn btn-warning AWD_delete_media"><i class="icon-minus icon-white"></i></button>';
      }
      $html.='
      </div>
      </div>';

      $this->controlGroupLabel($fieldId, $html, $class, $label, 'control-label');

      return $html;
      } */

    public function getHtml($config)
    {
        //get the method to call from the config type
        $method = $this->getMethodByType($config['type']);
        return call_user_func_array(array($this, $method), array($config));
    }

    /**
     * Create a control group container
     * @param array $config
     * @return string
     */
    public function createControlGroup($config)
    {
        $field = $this->getHtml($config);
        $html = '<div class="' . $config['class'] . ' ' . $config['type'] . '">';
        if ($config['label']) {
            $label = $this->createLabel($config);
            if ($config['label_after']) {
                $html .= $field . ' ' . $label;
            } else if ($config['type'] == 'checkbox') {
                $html .= str_replace('>', '>' . $field, $label);
            } else {
                $html .= $label . ' ' . $field;
            }
        } else {
            $html .= $field;
        }

        if ($config['help']) {
            $html .= '<span class="help-block">' . $config['help'] . '</span>';
        }
        $html .= '</div>';

        return $html;
    }

    public function createLabel($config)
    {
        $id = sanitize_key($config['name']);
        return '<label for="' . $id . '" ' . $this->processAttr($config['label_attr']) . '>' . $config['label'] . '</label>';
    }

    public function proccessFields($id, $fields)
    {
        $html = '';
        if (count($fields) > 0) {
            foreach ($fields as $field) {
                $field = $this->mergeOptions($field);
                if (!$field['type']) {
                    continue;
                }
                //set the name of the fiels id_fieldsetId[fieldname]
                if ($field['type'] != 'html') {
                    $field['name'] = $this->id . '_' . $id . '[' . $field['name'] . ']';
                }
                //create html elemments
                if (!$field['group']) {
                    $html .= $this->getHtml($field);
                } else {
                    $html .= $this->createControlGroup($field);
                }
            }
        }

        return $html;
    }

    /* public function isWidget($widget = null)
      {
      if (is_object($widget))
      return is_subclass_of($widget, 'WP_Widget');

      return is_subclass_of($this->widget, 'WP_Widget');
      } */
}
