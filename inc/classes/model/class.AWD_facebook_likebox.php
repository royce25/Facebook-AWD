<?php

/**
 *
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 *
 */
class AWD_facebook_likebox
{

    /**
     * href
     * the URL of the Facebook Page for this Like Box
     */
    protected $href;

    /**
     * width
     * the width of the plugin in pixels. Default width: 300px
     */
    protected $width;

    /**
     * height
     * the height of the plugin in pixels. The default height varies based on number of faces to display, and whether the stream is displayed. With the stream displayed, and 10 faces the default height is 556px. With no faces, and no stream the default height is 63px
     */
    protected $height;

    /**
     * colorscheme
     * the color scheme for the plugin. Options: 'light', 'dark'
     */
    protected $colorscheme;

    /**
     * show_faces
     * specifies whether or not to display profile photos in the plugin. Default value: true
     */
    protected $show_faces;

    /**
     * stream
     * specifies whether to display a stream of the latest posts from the Page's wall
     */
    protected $stream;

    /**
     * header
     * specifies whether to display the Facebook header at the top of the plugin
     */
    protected $header;

    /**
     * border_color
     * the border color of the plugin
     */
    protected $border_color;

    /**
     * force_wall
     * for Places, specifies whether the stream contains posts from the Place's wall or just checkins from friends. Default value: false
     */
    protected $force_wall;

    /**
     * template
     * template to use, xfbml, html5, or iframe
     */
    protected $type;

    /**
     * Constructor
     * @param array $options
     */
    public function __construct($options)
    {
        $this->setHref($options['href']);
        $this->setWidth($options['width']);
        $this->setHeight($options['height']);
        $this->setColorscheme($options['colorscheme']);
        $this->setShowFaces($options['show_faces']);
        $this->setStream($options['stream']);
        $this->setHeader($options['header']);
        $this->setBorderColor($options['border_color']);
        $this->setForceWall($options['force_wall']);
        $this->setType($options['type']);
    }

    /**
     * Setter: href
     * @param String $href
     * @return void
     */
    public function setHref($href)
    {
        if (empty($href))
            throw new Exception('Url for Like box can not be empty');
        $this->href = $href;
    }

    /**
     * Setter: width
     * @param String $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Setter: height
     * @param String $height
     * @return void
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Setter: colorscheme
     * @param String $colorscheme
     * @return void
     */
    public function setColorscheme($colorscheme)
    {
        $this->colorscheme = $colorscheme;
    }

    /**
     * Setter: show_faces
     * @param String $show_faces
     * @return void
     */
    public function setShowFaces($show_faces)
    {
        $this->show_faces = $show_faces;
    }

    /**
     * Setter: stream
     * @param String $stream
     * @return void
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    /**
     * Setter: header
     * @param String $header
     * @return void
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * Setter: border_color
     * @param String $border_color
     * @return void
     */
    public function setBorderColor($border_color)
    {
        $this->border_color = $border_color;
    }

    /**
     * Setter: force_wall
     * @param String $force_wall
     * @return void
     */
    public function setForceWall($force_wall)
    {
        $this->force_wall = $force_wall;
    }

    /**
     * Setter: type
     * @param String $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Getter: href
     * @return String
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Getter: width
     * @return String
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Getter: height
     * @return String
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Getter: colorscheme
     * @return String
     */
    public function getColorscheme()
    {
        return $this->colorscheme;
    }

    /**
     * Getter: show_faces
     * @return String
     */
    public function getShowFaces()
    {
        return $this->show_faces;
    }

    /**
     * Getter: stream
     * @return String
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Getter: header
     * @return String
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Getter: border_color
     * @return String
     */
    public function getBorderColor()
    {
        return $this->border_color;
    }

    /**
     * Getter: force_wall
     * @return String
     */
    public function getForceWall()
    {
        return $this->force_wall;
    }

    /**
     * Getter: type
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

     /**
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'likebox.php';
    }
}

?>
