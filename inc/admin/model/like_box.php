<?php
/*
*
* Fields Like button Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$fields['like_box'] = array(
	'title_config' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Configure the box',$this->plugin_text_domain).'</h1>
		'
	),
	
	'start_url' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'href'=> array(
		'type'=> 'text',
		'label'=> __('Url of the page',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'end_url' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'start_config' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'type'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'iframe', 'label'=>__('Iframe',$this->plugin_text_domain)),
			array('value'=>'xfbml', 'label'=>__('Xfbml',$this->plugin_text_domain)),							
			array('value'=>'html5', 'label'=>__('html5',$this->plugin_text_domain)),				
		),
		'label'=> __('Type',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'colorscheme'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'light', 'label'=>__('light',$this->plugin_text_domain)),
			array('value'=>'dark', 'label'=>__('Dark',$this->plugin_text_domain)),							
		),
		'label'=> __('Colors',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'show_faces'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Colors',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),

	'stream'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Show Stream ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'header'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Show Header ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'force_wall'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Force Wall ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'width'=> array(
		'type'=> 'text',
		'label'=> __('Width of box',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'height'=> array(
		'type'=> 'text',
		'label'=> __('Height of box',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'border_color'=> array(
		'type'=> 'text',
		'label'=> __('Border color',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
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
			<div class="well">'.$this->get_the_like_box().'</div>
			<h1>'.__('Options List',$this->plugin_text_domain).'</h1>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th>Option</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
					<tr><td>url</td><td>string</td></tr>
					<tr><td>width</td><td>number</td></tr>
					<tr><td>height</td><td>number</td></tr>
					<tr><td>colorscheme</td><td>light or dark</td></tr>
					<tr><td>faces</td><td>0 or 1</td></tr>
					<tr><td>border_color</td><td>hexadecimal string (ex: #ffffff for white)</td></tr>
					<tr><td>stream</td><td>like or recommend</td></tr>
					<tr><td>header</td><td>0 or 1</td></tr>
					<tr><td>type</td><td>xfbml or iframe or html5</td></tr>
					<tr><td>force_wall</td><td>string</td></tr>
				</tbody>
				<tfoot>
					<th colspan="2">[AWD_likebutton option="value"]</th>
				</tfoot>
			</table>
		'
	)
);
?>