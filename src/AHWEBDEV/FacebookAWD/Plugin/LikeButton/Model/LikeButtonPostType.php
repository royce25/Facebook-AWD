<?php

namespace AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model;

use AHWEBDEV\Framework\Model\Model;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * LikeButtonPostType
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD
 */
class LikeButtonPostType extends Model
{

    const POSITION_TOP = 'top';
    const POSITION_BOTTOM = 'bottom';
    const POSITION_BOTH = 'both';

    protected $enable = false;
    protected $position = self::POSITION_TOP;

    /**
     *
     * @var \AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButton 
     */
    protected $likeButton;

    /**
     * 
     * @return \AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButton
     */
    public function getLikeButton()
    {
        return $this->likeButton;
    }

    /**
     * 
     * @param \AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButton $likeButton
     * @return \AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButtonPostType
     */
    public function setLikeButton(\AHWEBDEV\FacebookAWD\Plugin\LikeButton\Model\LikeButton $likeButton)
    {
        $this->likeButton = $likeButton;
        return $this;
    }

    /**
     *
     * @return type
     */
    protected function getDefaultFormConfig()
    {
        return array(
            'enable' => array(
                'type' => 'select',
                'label' => 'Enable',
                'help' => 'Display or hide the like button',
                'options' => array(
                    array('value' => 0, 'label' => 'No'),
                    array('value' => 1, 'label' => 'Yes')
                )
            ),
            'position' => array(
                'type' => 'select',
                'label' => 'Where ?',
                'help' => 'The position of the like button',
                'options' => array(
                    array('value' => 'top', 'label' => 'Before content'),
                    array('value' => 'bottom', 'label' => 'After content'),
                    array('value' => 'both', 'label' => 'Before & after content'),
                )
            ),
        );
    }

}
