<?php

namespace AHWEBDEV\Framework;

use AHWEBDEV\Framework\Plugin\Plugin;

/*
 * This file is part of the little Framework AHWEBDEV.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ContainerInterface
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package AHWEBDEV\Framework
 */
interface ContainerInterface
{

    /**
     * Init of the framework
     */
    public function init();

    public function get($name);

    public function set($name, $service);

    public function getAssets();

    public function setAssets(array $assets);

    public function getPlugins();

    public function setPlugins(array $plugins);

    public function getTitle();

    public function getSlug();

    public function getPtd();

    public function setTitle($title);

    public function setSlug($slug);

    public function setPtd($ptd);

    public function registerPlugin($name, Plugin $plugin);

    public function debug($echo = true);
}
