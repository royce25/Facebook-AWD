<?php
/*
*
* Fields Login button Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$fields['login_button'] = array(

	'title_config' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Configure the button',$this->plugin_text_domain).'</h1>
		'
	),
	
	'start_config' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'login_button_display_on_login_page'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),		
		'label'=> __('Logout Label',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_login_url'=> array(
		'type'=> 'text',
		'label'=> __('Width of button',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_logout_url'=> array(
		'type'=> 'text',
		'label'=> __('Url after login',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_logout_value'=> array(
		'type'=> 'text',
		'label'=> __('Url after logout',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_profile_picture'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),		
		'label'=> __('Show profile picture',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_faces'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),		
		'label'=> __('Show faces',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_maxrow'=> array(
		'type'=> 'text',
		'label'=> __('Max faces row',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2', 'disabled'=>($this->options['login_button_faces'] == "0" ? 'disabled' : ''))
	),
	
	'login_button_width'=> array(
		'type'=> 'text',
		'label'=> __('Width of button',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'login_button_image'=> array(
		'type'=> 'media',
		'label'=> __('Button Image',$this->plugin_text_domain),
		'class'=> 'span8',
		'attr'=> array('class'=>'span6')
	),

	'end_config' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'preview' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Preview',$this->plugin_text_domain).'</h1>
			<div class="well">'.$this->get_the_login_button().'</div>
			<h1>'.__('Options List',$this->plugin_text_domain).'</h1>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th>Option</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
					<tr><td>profile_picture</td><td>0 or 1</td></tr>
					<tr><td>faces</td><td>0 or 1</td></tr>
					<tr><td>maxrow</td><td>number (only if faces = 1)</td></tr>
					<tr><td>login_url</td><td>string</td></tr>
					<tr><td>logout_url</td><td>string</td></tr>
					<tr><td>width</td><td>number</td></tr>
					<tr><td>image</td><td>url</td></tr>
				</tbody>
				<tfoot>
					<th colspan="2">[AWD_likebutton option="value"]</th>
				</tfoot>
			</table>
		'
	)
);
?>