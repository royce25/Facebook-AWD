<?php

/**
 * AHWEBDEV Framework
 *
 * This file is part of the AHWEBDEV Framework
 * 
 */

namespace AHWEBDEV\FacebookAWD\OptionManager;

use AHWEBDEV\Framework\OptionManager\OptionManagerInterface;

/**
 * FacebookAWD
 *
 * This file is the base container of the Facebook AWD extension
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class OptionManager implements OptionManagerInterface
{

    protected $prefix;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function save($key, $element)
    {
        update_option($this->prefix . $key, $element);
    }

    /**
     * {@inheritdoc}
     */
    public function load($key)
    {
        return get_option($this->prefix . $key);
    }

}
