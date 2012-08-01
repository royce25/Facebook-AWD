<?php
/**
 * Class AWD_facebook_widget
 * @author Alexandre Hermann
 * @version 1.0
 * @copyright AHWEBDEV, 01/08/2012
 * @package Facebook AWD
 **/
class AWD_facebook_widget extends WP_Widget {
	
	/**
	 * Facebook AWD instance
	 */
	protected $AWD_facebook;
	
	/**
	 * string $id
	 */
	public $id_base;
	
	/**
	 * Array $model
	 */
	protected $model;
	
	/**
	 * mixed $self_callback
	 */
	protected $self_callback;
	
	/**
	 * string $plugin_text_domain
	 */
	protected $plugin_text_domain;
	
	/**
	 * Constructor widget
	 */
	public function __construct($options=array())
	{
		global $AWD_facebook;
			
		$default = array(
			'name'			=> '',
			'id_base'		=> '',
			'description' 	=> '',
			'model' 		=> array(),
			'self_callback' => array($this, 'content'),
			'text_domain' 	=> ''
		);
		$options = array_replace($default, $options);
		
		$this->AWD_facebook = $AWD_facebook;
		$this->name = $options['name'];
		$this->id_base = $options['id_base'];
		$this->model = $options['model'];
		$this->self_callback = $options['self_callback'];
		$this->plugin_text_domain = $options['text_domain'];
		
		//load_plugin_textdomain($this->plugin_text_domain, false, dirname(dirname( plugin_basename( __FILE__ ) ) ) . '/langs/');
		
        parent::WP_Widget($this->id_base, $this->name , $options);
    }
    
    /**
	 * Form
	 */
	public function form($instance)
	{
		$form = new AWD_facebook_form($this);
		$instance = $this->default_instance($instance);
		$html = '<div class="AWD_facebook_wrap">';
		$html .= $form->proccessFields($this->id_base, $this->model, $instance);
		$html .= '</div>';
		
		//redefine the style to feet in the widget area
		$html = str_replace('<div class="row">','<div class="row-fluid">', $html);
		$html = str_replace(array('span1','span2','span3','span4','span5','span6','span7','span8','span9','span10','span11'),'span12', $html);
		
		echo $html;
	}
	
	/**
	 * Update
	 */
	public function update($new_instance, $old_instance)
	{
		return stripslashes_deep($new_instance);
	}
	
	/**
	 * Content
	 */
	public function widget($args, $instance)
	{
		extract($args);
		$instance = $this->default_instance($instance);
		$instance['widget_title'] = apply_filters('widget_title', !isset($instance['widget_title']) ? '' : $instance['widget_title']);
		
		echo $before_widget;
		if($instance['widget_title']){
			echo $before_title . $instance['widget_title'] . $after_title;
		}
		echo call_user_func_array($this->self_callback, array($instance));
		echo $after_widget;
    }
    
    /**
     * DefaultOptions
     */
    public function default_instance($instance)
    {
    	return array_replace($instance, $this->AWD_facebook->options[$this->id_base]);		
    }
    
    /**
     * Default Callback function
     */
    public function content($instance)
    {
		throw new RuntimeException('You must define a valid callback');
    }
    
}
?>