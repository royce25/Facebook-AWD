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
	
	public function addInputText($label, $id, $value, $class, $attrs = array())
	{
		$html ='
		<div class="'.$class.'">
			<label>
				'.$label.'
				<input type="text" id="'.$this->prefix.$id.'" name="'.$this->prefix.$id.'" value="'.$value.'" ';
				$html .= $this->processAttr($attrs);
				$html .= '/>
			</label>
		</div>
		';
		return $html;
	}
	
	public function addSelect($label, $id, $values, $value ,$class, $attrs = array())
	{
		$html ='
		<div class="'.$class.'">
			<label>
				'.$label.'
				<select id="'.$this->prefix.$id.'" name="'.$this->prefix.$id.'" ';
				$html .= $this->processAttr($attrs);
				$html .= '>
				';
				foreach($values as $option=>$info){
					$html .='<option value="'.$info['value'].'" '.($info['value'] == $value ? 'selected="selected"' : '').' >'.$info['label'].'</option>';
				}
				$html .='
				</select> 
			</label>	
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
}