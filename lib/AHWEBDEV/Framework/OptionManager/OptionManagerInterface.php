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
interface OptionManagerInterface
{
    /**
     * Merge defined arguments into defaults array.
     *
     * @param object|string|array $args
     * @param array $defaults
     * @return array|string
     */
    public static function parseArgs($args, $defaults = '');

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set Options
     *
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * Get Option
     *
     * @param string $name
     * @return mixed
     */
    public function getOption($name, $value);

    /**
     * Set Option
     *
     * @param type $name
     * @param mixed $value
     */
    public function setOption($name, $value);

    /**
     * Get default Options
     *
     * @return array
     */
    public function getDefaultOptions();

    /**
     * Set Options
     *
     * @param array $options
     */
    public function setDefaultOptions(array $defaultOptions);

    /**
     * Load Options From database
     */
    public function load();

    /**
     * Save Options in database
     */
    public function save();

    /**
     * Reset Options in database
     */
    public function reset();
}

?>