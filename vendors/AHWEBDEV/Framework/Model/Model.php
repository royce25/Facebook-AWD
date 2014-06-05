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
        $config = array(
            'token' => array(
                'name' => 'token',
                'type' => 'hidden',
                'attr' => null,
                'value' => wp_create_nonce('fawd-token')
            )
        );
        $properties = get_object_vars($this);
        foreach ($properties as $key => $value) {
            $config[$key] = array(
                'name' => $key,
                'value' => $value
            );
        }
        $formConfig = array_merge_recursive($config, $this->getDefaultFormConfig());
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
        foreach ($data as $prop => $value) {
            $this->{$prop} = $value;
        }
    }

}
