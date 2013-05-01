<?php

/**
 * AWD_facebook_loginbutton
 *
 * This class generate login button for facebook.
 *
 * @package facebook-awd
 * @author AHWEBDEV (Alexandre Hermann)
 */
class AWD_facebook_loginbutton
{

    /**
     *
     * @var type
     */
    protected $loginRedirectUrl;

    /**
     *
     * @var type
     */
    protected $logoutRedirectUrl;

    /**
     *
     * @var type
     */
    protected $logoutLabel;

    /**
     *
     * @var type
     */
    protected $showProfilePicture;

    /**
     *
     * @var type
     */
    protected $showFaces;

    /**
     *
     * @var type
     */
    protected $maxRow;

    /**
     *
     * @var type
     */
    protected $width;

    /**
     *
     * @var type
     */
    protected $image;

    /**
     *
     */
    public function __construct($options)
    {
        $this->setLogoutLabel($options['logout_label']);
        $this->setLogoutRedirectUrl($options['logout_redirect_url']);
        $this->setLoginRedirectUrl($options['login_redirect_url']);
        $this->setShowProfilePicture($options['show_profile_picture']);
        $this->setShowFaces($options['show_faces']);
        $this->setMaxRow($options['maxrow']);
        $this->setWidth($options['width']);
        $this->setImage($options['image']);
    }

    /**
     *
     * @return string
     */
    public function getLoginRedirectUrl()
    {
        return $this->loginRedirectUrl;
    }

    /**
     *
     * @param string $loginRedirectUrl
     */
    public function setLoginRedirectUrl($loginRedirectUrl)
    {
        $this->loginRedirectUrl = $loginRedirectUrl;
    }

    /**
     *
     * @return string
     */
    public function getLogoutRedirectUrl()
    {
        return $this->logoutRedirectUrl;
    }

    /**
     *
     * @param string $logoutRedirectUrl
     */
    public function setLogoutRedirectUrl($logoutRedirectUrl)
    {
        $this->logoutRedirectUrl = $logoutRedirectUrl;
    }

    /**
     *
     * @return string
     */
    public function getLogoutLabel()
    {
        return $this->logoutLabel;
    }

    /**
     *
     * @param string $logoutLabel
     */
    public function setLogoutLabel($logoutLabel)
    {
        $this->logoutLabel = $logoutLabel;
    }

    /**
     *
     * @return boolean
     */
    public function getShowProfilePicture()
    {
        return $this->showProfilePicture;
    }

    /**
     *
     * @param boolean $showProfilePicture
     */
    public function setShowProfilePicture($showProfilePicture)
    {
        $this->showProfilePicture = $showProfilePicture;
    }

    /**
     *
     * @return boolean
     */
    public function getShowFaces()
    {
        return $this->showFaces;
    }

    /**
     *
     * @param boolean $showFaces
     */
    public function setShowFaces($showFaces)
    {
        $this->showFaces = $showFaces;
    }

    /**
     *
     * @return integer
     */
    public function getMaxRow()
    {
        return $this->maxRow;
    }

    /**
     *
     * @param integer $maxRow
     */
    public function setMaxRow($maxRow)
    {
        $this->maxRow = $maxRow;
    }

    /**
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     *
     * @param integer $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * return string
     */
    public function getTemplate()
    {
        return 'loginbutton.php';
    }

}

?>