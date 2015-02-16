<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 * @author Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */

namespace AHWEBDEV\Wordpress\PluginBundle\Admin;

use AHWEBDEV\Wordpress\PluginBundle\Admin\AdminPage;

/**
 * This is the base Admin Page class
 *
 * This file add required hooks in wordpress admin using controllers and models
 * 
 * @package      AHWEBDEVWordpressPluginBundle
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class AdminPage
{

    const TYPE_PAGE = 'page';
    const TYPE_SUBPAGE = 'subpage';

    protected $id;
    protected $title;
    protected $type;
    protected $iconUrl;
    protected $pageHook;
    protected $parent;
    protected $wpRouter;
    protected $pool;

    public function __construct($id, $title, $iconUrl = "", $parent = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->iconUrl = $iconUrl;
        $this->type = self::TYPE_PAGE;

        //define parents
        $this->parent = $parent;
        if ($this->parent instanceof AdminPage) {
            $this->type = self::TYPE_SUBPAGE;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;
        return $this;
    }

    public function getPageHook()
    {
        return $this->pageHook;
    }

    public function setPageHook($pageHook)
    {
        $this->pageHook = $pageHook;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

}
