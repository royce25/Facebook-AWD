<?php

namespace AHWEBDEV\FacebookAWD\Extension;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Container as BaseContainer;
use AHWEBDEV\Framework\TemplateManager\TemplateManager;
//use AHWEBDEV\Framework\OptionManager\OptionManager;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extension
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD\Extension
 */
abstract class Container extends BaseContainer
{
    /**
     * The FacebookAWD instance
     *
     * @var FacebookAWD
     */
    protected $facebookAWD;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facebookAWD = new FacebookAWD();

        //Should be mooved to the FWks
        //$this->setOptionManager(new OptionManager());
        $this->setTemplateManager(new TemplateManager());

        parent::__construct();
    }

    /**
     * Get the FacebookAWD instance
     * @return FacebookAWD
     */
    public function getFacebookAWD()
    {
        return $this->facebookAWD;
    }
}

?>
