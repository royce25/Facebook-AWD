<?php

namespace AHWEBDEV\FacebookAWD\Model;

use AHWEBDEV\FacebookAWD\FacebookAWD;
use AHWEBDEV\Framework\Model\Model;

/**
 * Facebook AWD Application Model
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
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
     * @return type
     */
    protected function getDefaultFormConfig()
    {
        return array(
            'id' => array(
                'type' => 'text',
                'label' => __('Identifier', $this->container->getPtd()),
            ),
            'secretKey' => array(
                'type' => 'text',
                'label' => __('Secret Key', $this->container->getPtd()),
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
        if (isset($this->monthly_active_users)) {
            $this->iconUrl = $this->icon_url;
            $this->logoUrl = $this->logo_url;
            $this->monthlyActiveUsers = $this->monthly_active_users;
            unset($this->icon_url);
            unset($this->logo_url);
            unset($this->monthly_active_users);
        }
    }

}
