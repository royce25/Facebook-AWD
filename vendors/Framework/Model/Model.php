<?php

namespace AHWEBDEV\Framework\Model;

/**
 * Facebook AWD Application Model
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
abstract class Model implements FormConfigInterface
{

    /**
     *
     * @return array
     */
    public function getFormConfig()
    {
        $config = array();
        $reflector = new \ReflectionClass(get_class($this));
        foreach ($this as $key => $prop) {
            if ($reflector->hasProperty($key)) {
                $config[$key] = array(
                    'name' => $key,
                    'value' => $prop
                );
            }
        }
        $formConfig = array_replace_recursive($config, $this->getDefaultFormConfig());
        $formConfigFiltered = apply_filters('AWD_facebook_fields_' . get_class($this), $formConfig);        
        
        return $formConfigFiltered;
    }

    /**
     *
     * @param  array                                   $formConfig
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setFormConfig(array $formConfig)
    {
        $this->formConfig = $formConfig;

        return $this;
    }

    /**
     *
     * @param array $data
     */
    public function bind(array $data)
    {
        $reflector = new \ReflectionClass(get_class($this));
        foreach ($data as $propertyName => $value) {
            if ($reflector->hasProperty($propertyName)) {
                $this->{$propertyName} = $value;
            }
        }
    }

}
