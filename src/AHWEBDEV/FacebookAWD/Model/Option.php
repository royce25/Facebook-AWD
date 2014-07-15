<?php

namespace AHWEBDEV\FacebookAWD\Model;

use AHWEBDEV\Framework\Model\Model;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Application
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD
 */
class Option extends Model
{

    /**
     *
     * @var string
     */
    protected $allowDataCollect;

    /**
     *
     * @return boolean
     */
    public function getAllowDataCollect()
    {
        return $this->allowDataCollect;
    }

    /**
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
     *
     * @return type
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
