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
	
	public function addInputText($label, $id, $value, $class, $attrs = array(), $prepend = '',$append ='')
	{
		$html ='
		<div class="'.$class.'">
			<label for="'.$this->prefix.$id.'">'.$label.'</label>';
			if($prepend != '' OR $append){
				$html .= '
				<div class="'.($append != '' ? 'input-append' : '').' '.($prepend != '' ? 'input-prepend' : '').' ">';
			} 
			if($prepend != ''){
				$html .= '<span class="add-on"><i class="'.$prepend.'"></i></span>';
			}
			$html .= '<input type="text" id="'.$this->prefix.$id.'" name="'.$this->prefix.$id.'" value="'.$value.'" '.$this->processAttr($attrs).' />';
			if($append != ''){
				$html .= $append;
			}
			if($prepend OR $append){
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
		if(is_array($attrs) && count($attrs)){
			foreach($attrs as $attr=>$value){
				if($value != ''){
					$html .= $attr.'="'.$value.'" ';
				}
			}
		}
		return $html;
	}
	
	public function addMediaButton($label, $id, $value, $class, $attrs = array(),$datas=array('data-title'=>'Upload Media', 'data-type'=> 'image'), $rm=false)
	{
		$html ='
		<div class="'.$class.'">
			<label for="'.$this->prefix.$id.'">'.$label.'</label>
			<div class="input-append">
				<input type="text" id="'.$this->prefix.$id.'" name="'.$this->prefix.$id.'" value="'.$value.'" '.$this->processAttr($attrs).' />
				<button class="btn AWD_button_media btn-info" type="button" '.$this->processAttr($datas).' data-field="'.$this->prefix.$id.'"><i class="icon-white icon-picture"></i></button>';
				if($rm == true){
					$html .='<button class="btn btn-warning"><i class="icon-minus icon-white"></i></button>';
				}
			$html.='</div>
		</div>';
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
					case 'media':
						$html.= $this->addMediaButton($field['label'].' '.$AWD_facebook->get_the_help($id), $id, $AWD_facebook->options[$id], $field['class'], $field['attr']); 
					break;
				}
			}
		}
		return $html;
	}
	
}