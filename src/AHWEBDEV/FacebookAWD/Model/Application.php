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
class Application extends Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $secretKey;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $link;

    /**
     *
     * @var string
     */
    protected $namespace;

    /**
     *
     * @var string
     */
    protected $iconUrl;

    /**
     *
     * @var string
     */
    protected $logoUrl;

    /**
     *
     * @var integer
     */
    protected $monthlyActiveUsers;

    /**
     *
     * @var integer
     */
    protected $monthlyActiveUsersRank;

    /**
     *
     * @var integer
     */
    protected $dailyActiveUsers;

    /**
     *
     * @var integer 
     */
    protected $dailyActiveUsersRank;

    /**
     * 
     * @var integer 
     */
    protected $weeklyActiveUsers;

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param  integer                                 $id
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     *
     * @param  string                                  $secretKey
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param  string                                  $name
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     *
     * @param  string                                  $link
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     *
     * @param  string                                  $namespace
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    /**
     *
     * @param  string                                  $iconUrl
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     *
     * @param  string                                  $logoUrl
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getMonthlyActiveUsers()
    {
        return $this->monthlyActiveUsers;
    }

    /**
     *
     * @param  integer                                 $monthlyActiveUsers
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setMonthlyActiveUsers($monthlyActiveUsers)
    {
        $this->monthlyActiveUsers = $monthlyActiveUsers;

        return $this;
    }

    /**
     * 
     * @return integer
     */
    public function getDailyActiveUsers()
    {
        return $this->dailyActiveUsers;
    }

    /**
     * 
     * @param integer $dailyActiveUsers
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setDailyActiveUsers($dailyActiveUsers)
    {
        $this->dailyActiveUsers = $dailyActiveUsers;
        return $this;
    }

    /**
     * 
     * @return integer
     */
    public function getMonthlyActiveUsersRank()
    {
        return $this->monthlyActiveUsersRank;
    }

    /**
     * 
     * @return integer
     */
    public function getDailyActiveUsersRank()
    {
        return $this->dailyActiveUsersRank;
    }

    /**
     * 
     * @return integer
     */
    public function getWeeklyActiveUsers()
    {
        return $this->weeklyActiveUsers;
    }

    /**
     * 
     * @param integer $monthlyActiveUsersRank
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setMonthlyActiveUsersRank($monthlyActiveUsersRank)
    {
        $this->monthlyActiveUsersRank = $monthlyActiveUsersRank;
        return $this;
    }

    /**
     * 
     * @param integer $dailyActiveUsersRank
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setDailyActiveUsersRank($dailyActiveUsersRank)
    {
        $this->dailyActiveUsersRank = $dailyActiveUsersRank;
        return $this;
    }

    /**
     * 
     * @param integer $weeklyActiveUsers
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setWeeklyActiveUsers($weeklyActiveUsers)
    {
        $this->weeklyActiveUsers = $weeklyActiveUsers;
        return $this;
    }

    /**
     *
     * @return type
     */
    protected function getDefaultFormConfig()
    {
        return array(
            'id' => array(
                'type' => 'text',
                'label' => 'Identifier',
                'help' => 'This is the ID of your facebook application. You can find it or create an application <a href="https://developers.facebook.com/">here</a>'
            ),
            'secretKey' => array(
                'type' => 'text',
                'label' => 'Secret Key',
                'help' => 'This is the secret key of your facebook application. You can find it or create an application <a href="https://developers.facebook.com/">here</a>'
            )
        );
    }

    /**
     *
     * @param array $data
     */
    public function bind(array $data)
    {
        parent::bind($data);

        //camelCase respect
        if (isset($data['monthly_active_users'])) {
            $this->iconUrl = $data['icon_url'];
            $this->logoUrl = $data['logo_url'];
            $this->monthlyActiveUsers = $data['monthly_active_users'];
            $this->monthlyActiveUsersRank = $data['monthly_active_users_rank'];
            $this->dailyActiveUsers = $data['daily_active_users'];
            $this->dailyActiveUsersRank = $data['daily_active_users_rank'];
            $this->weeklyActiveUsers = $data['weekly_active_users'];
        }
    }

}
