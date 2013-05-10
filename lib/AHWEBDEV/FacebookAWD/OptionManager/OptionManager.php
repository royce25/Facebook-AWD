<?php

namespace AHWEBDEV\FacebookAWD\OptionManager;

use AHWEBDEV\FacebookAWD\FacebookAWD;

/**
 *
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 *
 */
class OptionManager
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
     * The instance of FacebookAWD
     * @var \AHWEBDEV\FacebookAWD\FacebookAWD
     */
    protected $facebookAWD;

    /**
     *
     * @param \AHWEBDEV\FacebookAWD\FacebookAWD $facebookAWD
     */
    public function __construct(FacebookAWD $facebookAWD)
    {
        $this->facebookAWD = $facebookAWD;
    }

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

    /**
     * Load Options From database and apply filter : apply_filters($this->filterName, get_option($this->filterName));
     * @return void

      public function load()
      {
      $this->options = apply_filters($this->filterName, get_option($this->filterName));
      }

      /**
     * Save options

      public function save()
      {
      update_option($this->filterName, $this->checkConfig($this->options));
      }

      /**
     * Update option

      public function updateOption($name, $value, $flush = false)
      {
      $this->options[$name] = $value;
      if ($flush === true)
      $this->save();

      return $this->options[$name];
      }

      /**
     * Reset all Options with a new empty array.

      public function reset()
      {
      update_option($this->filterName, array());
      }
     */
}

?>