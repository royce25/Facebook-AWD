<?php

namespace AHWEBDEV\Framework\Model;

/**
 * Facebook AWD Application Model
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
interface FormConfigInterface
{

    /**
     *
     * @return array
     */
    public function getFormConfig();

    /**
     *
     * @param array $formConfig
     */
    public function setFormConfig(array $formConfig);

}
