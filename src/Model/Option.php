<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Model;

use AHWEBDEV\Framework\Model\Model;

/**
 * This is the model options
 *
 * This file represent a model of key/pair options that can be stored in memory
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class Option extends Model
{

    /**
     * Allow the collect of data
     * 
     * @var string
     */
    protected $allowDataCollect;

    /**
     * Get the allowed the collect of data
     * @return boolean
     */
    public function getAllowDataCollect()
    {
        return $this->allowDataCollect;
    }

    /**
     * Set the allowed the collect of data
     * 
     * @param  Boolean                            $allowDataCollect
     * @return \AHWEBDEV\FacebookAWD\Model\Option
     */
    public function setAllowDataCollect($allowDataCollect)
    {
        $this->allowDataCollect = $allowDataCollect;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormConfig()
    {
        return array(
            'allowDataCollect' => array(
                'type' => 'select',
                'label' => 'Allow data share with ahwebdev.fr',
                'help' => 'This will help us to fix bugs and optimize this plugin',
                'options' => array(
                    array('value' => '0', 'label' => 'No'),
                    array('value' => '1', 'label' => 'Yes'),
                )
            )
        );
    }

}
