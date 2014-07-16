<?php

/**
 * Facebook AWD
 *
 * This file is part of tha Facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Model;

use AHWEBDEV\Framework\Model\Model;

/**
 * This is the model of a facebook Application
 *
 * This file is used to represent a facebook application.
 * (Will be removed before 2.0)
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class Application extends Model
{

    /**
     * The id of the application
     * 
     * @var integer
     */
    protected $id;

    /**
     * The secret key of the application
     * @var string
     */
    protected $secretKey;

    /**
     * the name of the application
     * 
     * @var string
     */
    protected $name;

    /**
     * the public link of the application
     * 
     * @var string
     */
    protected $link;

    /**
     * The namespace of the application
     * 
     * @var string
     */
    protected $namespace;

    /**
     * the iconUrl of the application
     * 
     * @var string
     */
    protected $iconUrl;

    /**
     * The logo Url of the application
     * @var string
     */
    protected $logoUrl;

    /**
     * the nb of montly active users
     * 
     * @var integer
     */
    protected $monthlyActiveUsers;

    /**
     * the rank of montly active users
     * 
     * @var integer
     */
    protected $monthlyActiveUsersRank;

    /**
     * the nb of daily active users
     * 
     * @var integer
     */
    protected $dailyActiveUsers;

    /**
     * the rank of daily active users
     * 
     * @var integer
     */
    protected $dailyActiveUsersRank;

    /**
     * the nb of weekly active users
     * 
     * @var integer
     */
    protected $weeklyActiveUsers;

    /**
     * Get the id
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id
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
     * Get the secret key
     * 
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Set the secret key
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
     * Get the name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name
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
     * Get the link
     * 
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the link
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
     * Get the namespace
     * 
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the namespace
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
     * Get the icon url
     * 
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    /**
     * Set the icon url
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
     * Get the logo url
     *
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * Set the icon url
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
     * Get the nb of monthly active users
     * 
     * @return integer
     */
    public function getMonthlyActiveUsers()
    {
        return $this->monthlyActiveUsers;
    }

    /**
     * Set the nb of monthly active users
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
     * Get the nb of dayly active users
     * 
     * @return integer
     */
    public function getDailyActiveUsers()
    {
        return $this->dailyActiveUsers;
    }

    /**
     * Set the nb of dayly active users
     * 
     * @param  integer                                 $dailyActiveUsers
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setDailyActiveUsers($dailyActiveUsers)
    {
        $this->dailyActiveUsers = $dailyActiveUsers;

        return $this;
    }

    /**
     * Get the rank of monthly active users
     *
     * @return integer
     */
    public function getMonthlyActiveUsersRank()
    {
        return $this->monthlyActiveUsersRank;
    }

    /**
     * Get the rank of daily active users
     * 
     * @return integer
     */
    public function getDailyActiveUsersRank()
    {
        return $this->dailyActiveUsersRank;
    }

    /**
     * Get the nb of Weekly active users
     * 
     * @return integer
     */
    public function getWeeklyActiveUsers()
    {
        return $this->weeklyActiveUsers;
    }

    /**
     * Set the rank of monthly active users
     * 
     * @param  integer                                 $monthlyActiveUsersRank
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setMonthlyActiveUsersRank($monthlyActiveUsersRank)
    {
        $this->monthlyActiveUsersRank = $monthlyActiveUsersRank;

        return $this;
    }

    /**
     * Set the rank of daily active users
     * 
     * @param  integer                                 $dailyActiveUsersRank
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setDailyActiveUsersRank($dailyActiveUsersRank)
    {
        $this->dailyActiveUsersRank = $dailyActiveUsersRank;

        return $this;
    }

    /**
     * Set the nb of weekly active users
     * 
     * @param  integer                                 $weeklyActiveUsers
     * @return \AHWEBDEV\FacebookAWD\Model\Application
     */
    public function setWeeklyActiveUsers($weeklyActiveUsers)
    {
        $this->weeklyActiveUsers = $weeklyActiveUsers;

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
