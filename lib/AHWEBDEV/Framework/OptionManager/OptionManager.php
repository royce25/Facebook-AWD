<?php

namespace AHWEBDEV\Framework\OptionManager;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * OptionManagerInterface
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
class OptionManager implements OptionManagerInterface
{

    /**
     * The options
     * @var array
     */
    protected $options = array();

    /**
     * The default options
     * @var array
     */
    protected $defaultOptions = array();

    /**
     * Merge defined arguments into defaults array.
     * @param object|string|array $args
     * @param array $defaults
     * @return array|string
     */
    public static function parseArgs($args, $defaults = '')
    {
        if (is_object($args))
            $r = get_object_vars($args);
        elseif (is_array($args))
            $r = & $args;
        else
            parse_str($args, $r);

        if (is_array($defaults))
            return array_merge($defaults, $r);
        return $r;
    }

    /**
     * Get options
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set Options
     * @param array $options
     * @return \AHWEBDEV\FacebookAWD\OptionManager\OptionManager
     */
    public function setOptions(array $options)
    {
        $this->options = self::parseArgs($options, $this->defaultOptions);
        return $this;
    }

    /**
     * Get defaults Options
     * @return array
     */
    public function getDefaultOptions()
    {
        return require "options.php";
    }

    /**
     * Add defaults Options
     * @param string $name
     * @param string|object|array $value
     * @return \AHWEBDEV\FacebookAWD\OptionManager\OptionManager
     */
    public function addDefaultOptions($name, $value)
    {
        $this->defaultOptions[$name] = $value;
        return $this;
    }

    /**
     * Set the default options
     * @param array $defaultOptions
     * @return \AHWEBDEV\FacebookAWD\OptionManager\OptionManager
     */
    public function setDefaultOptions(array $defaultOptions)
    {
        $this->defaultOptions = $defaultOptions;
        return $this;
    }

    public function load()
    {

    }

    public function reset()
    {

    }

    public function save()
    {

    }
}

?>