<?php

namespace AHWEBDEV\Framework\TemplateManager;

/**
 *
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 *
 */
class Form
{

    protected $id;
    protected $method = 'GET';
    protected $action;
    protected $widget;

    public function __construct($id = null, $method = null, $action = null)
    {
        $this->id = $id;
        $this->method = $method;
        $this->action = $action;
        if ($this->isWidget($this->id)) {
            $this->id = null;
            $this->widget = $id;
        }
    }

    public function isWidget($widget = null)
    {
        if (is_object($widget))
            return is_subclass_of($widget, 'WP_Widget');

        return is_subclass_of($this->widget, 'WP_Widget');
    }

    public function start()
    {
        $html = '<form action="' . $this->action . '" method="' . $this->method . '" id="' . $this->id . '" name="' . $this->prefix . $this->id . '">';

        return $html;
    }

    public function end()
    {
        $html = '</form>';

        return $html;
    }

    public function addInputCheckBox($id, $value, $class = '', $attrs = array())
    {
        $field_id = $this->getFieldId($id);
        $html = '<input type="checkbox" id="' . $field_id . '" ' . ($value == 1 ? 'checked="checked"' : '') . 'name="' . $this->prefix . $id . '" value="1" ' . $this->processAttr($attrs) . ' />';

        return $html;
    }

    public function addInputHidden($config)
    {
        $default = array();
        $config = array_merge($default, $config);
        $id = $this->getFieldId($config['name']);
        $html = '<input type="hidden" id="' . $id . '" name="' . $config['name'] . '" value="' . $config['value'] . '" ' . $this->processAttr($config['attr']) . ' />';

        return $html;
    }

    public function addInputTextArea($label, $id, $value, $class = '', $attrs = array())
    {
        $field_id = $this->getFieldId($id);
        $html = '
            <div class="' . $class . '">
                <label for="' . $field_id . '">' . $label . '</label>
                <textarea id="' . $field_id . '" name="' . $this->prefix . $id . '" ' . $this->processAttr($attrs) . '>' . $value . '</textarea>
            </div>';

        return $html;
    }

    public function addInputText($config)
    {
        $default = array(
            'label_attr' => array('class' => 'control-label'),
            'class' => 'form-group',
            'attr' => array('class' => 'form-control')
        );
        $config = array_merge($default, $config);
        $id = $this->getFieldId($config['name']);

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

        return $this->controlGroupLabel($html, $config);

        //return $html;
    }

    /* public function addSelect($label, $id, $options, $value, $class = '', $attrs = array())
      {
      $field_id = $this->getFieldId($id);
      $html = '<div class="' . $class . '">
      <label for="' . $field_id . '">' . $label . '</label>
      <select id="' . $field_id . '" name="' . $this->prefix . $id . '" ';

      $html .= $this->processAttr($attrs);
      $html .= '>';

      foreach ($options as $option => $info) {
      $html .='<option value="' . $info['value'] . '" ' . ($info['value'] == $value ? 'selected="selected"' : '') . ' >' . $info['label'] . '</option>';
      }

      $html .='</select>
      </div>';

      return $html;
      } */

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

    /* public function addMediaButton($label, $id, $value, $class = '', $attrs = array(), $datas = array('data-title' => 'Upload Media', 'data-type' => 'image'), $rm = false)
      {
      $fieldId = $this->getFieldId($id);
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

    public function controlGroupLabel($content, $config)
    {
        $content = $this->addLabel($config) . $content;

        return $this->controlGroup($content, $config);
    }

    public function controlGroup($content, $config)
    {
        $html = '<div class="' . $config['class'] . '">';
        $html .= $content;
        $html .= '</div>';

        return $html;
    }

    public function getFieldId($fieldname)
    {
        return rtrim(str_replace(array('[', ']', '__'), '_', $fieldname), '_');
    }

    public function addLabel($config)
    {

        $id = $this->getFieldId($config['name']);

        return '<label for="' . $id . '" ' . $this->processAttr($config['label_attr']) . '>' . $config['label'] . '</label>';
    }

    public function proccessFields($fieldsetId, $fields, $widget_instance = null)
    {
        $html = '';
        if (count($fields) > 0) {
            foreach ($fields as $field) {
                if (!isset($field['type'])) {
                    continue;
                }
                //if we are in a widget, check if we need to display html or not.
                /* if ($this->isWidget() && isset($field['widget_no_display'])) {
                  if ($field['widget_no_display'] == true) {
                  continue;
                  }
                  } */

                /* if (!$this->isWidget() && isset($field['widget_only'])) {
                  if ($field['widget_only'] == true) {
                  continue;
                  }
                  } */

                //get the value of the field only if it's not a html content
                if ($field['type'] != 'html') {
                    //if we are in widget mode, we must redefine the name of field, and the associated values
                    /* if ($this->isWidget()) {
                      $fieldname = $this->widget->get_field_name($id);
                      $value = $widget_instance[$id];
                      } else { */
                    $field['name'] = $this->id . '_' . $fieldsetId . '[' . $field['name'] . ']';
                    //$value = $field['value'];
                    //}
                }

                switch ($field['type']) {

                    case 'select':
                        $html.= $this->addSelect($field['label'], $fieldname, $field['options'], $value, $field['class'], $field['attr']);
                        break;
                    case 'text':
                        $html.= $this->addInputText($field);
                        break;
                    case 'hidden':
                        $html.= $this->addInputHidden($field);
                        break;
                    case 'html':
                        $html.= $field['html'];
                        break;
                    case 'media':
                        $html.= $this->addMediaButton($field['label'], $fieldname, $value, $field['class'], $field['attr']);
                        break;
                }
            }
        }

        return $html;
    }

}
