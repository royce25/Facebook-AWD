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
     *
     * @param string $key
     * @param Object $element
     */
    public function save($key, $element)
    {
        update_option($key, $element);
    }

    /**
     *
     * @param string $key
     */
    public function load($key)
    {
        return get_option($key);
    }

}

?>