<?php 
/**
 * 
 *
 * @author Alexandre Hermann
 * @version 1.4
 * @copyright AHWEBDEV, 6 June, 2012
 * @package Facebook AWD
 **/
class AWD_facebook_form
{

	protected $id;
	protected $method = 'GET';
	protected $action;
	protected $prefix;
	 
	public function __construct($id, $method, $action, $prefix)
	{
		$this->id = $id;
		$this->method = $method;
		$this->action = $action;
		$this->prefix = $prefix;
	}
	
	public function start()
	{
		$html =
		'
		<form action="'.$this->action.'" method="'.$this->method.'" id="'.$this->prefix.$this->id.'" name="'.$this->prefix.$this->id.'">
		';
		return $html;
	}
	
	public function end()
	{
		$html =
		'
		</form>
		';
		return $html;
	}
	
	public function addInputText($label, $id, $value, $class, $attrs = array(), $prepend = '')
	{
		$html ='
		<div class="'.$class.'">
			<label for="'.$this->prefix.$id.'">'.$label.'</label>';
			if($prepend != ''){
				$html .= '
				<div class="input-prepend">
					<span class="add-on"><i class="'.$prepend.'"></i></span>';
			} 
			$html .= '<input type="text" id="'.$this->prefix.$id.'" name="'.$this->prefix.$id.'" value="'.$value.'" '.$this->processAttr($attrs).' />';
			if($prepend != ''){
				$html .= '
				</div>';
			}
		$html .='
		</div>';
		return $html;
	}
	
	public function addSelect($label, $id, $values, $value ,$class, $attrs = array())
	{
		$html ='
		<div class="'.$class.'">
			<label for="'.$this->prefix.$id.'">'.$label.'</label>
			<select id="'.$this->prefix.$id.'" name="'.$this->prefix.$id.'" ';
			$html .= $this->processAttr($attrs);
			$html .= '>
			';
			foreach($values as $option=>$info){
				$html .='<option value="'.$info['value'].'" '.($info['value'] == $value ? 'selected="selected"' : '').' >'.$info['label'].'</option>';
			}
			$html .='
			</select> 
		</div>';	
		return $html;
	}
	
	protected function processAttr($attrs)
	{
		$html = '';
		foreach($attrs as $attr=>$value){
			$html .= $attr.'="'.$value.'" ';
		}
		return $html;
	}
	
	
	public function proccessFields($fields)
	{
		global $AWD_facebook;
		$html = '';
		if(count($fields)>0){
			foreach($fields as $id=>$field)
			{	
				switch($field['type'])
				{
					case 'select':
						$html.= $this->addSelect($field['label'].' '.$AWD_facebook->get_the_help($id), $id, $field['options'], $AWD_facebook->options[$id], $field['class'], $field['attr']);
					break;
					
					case 'text':
						$html.= $this->addInputText($field['label'].' '.$AWD_facebook->get_the_help($id), $id, $AWD_facebook->options[$id], $field['class'], $field['attr']); 
					break;	
					case 'html':
						$html.= $field['html']; 
					break;	
				}
			}
		}
		return $html;
	}
	
}