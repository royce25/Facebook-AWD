<?php
/*
*
* Fields Like button Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$fields['activity_box'] = array(
	'title_config' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Configure the box',$this->plugin_text_domain).'</h1>
		'
	),
	
	'start_domain' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'activity_domain'=> array(
		'type'=> 'text',
		'label'=> __('Domain',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'end_domain' => array(
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
	
	'activity_type'=> array(
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
	
	'activity_filter'=> array(
		'type'=> 'text',
		'label'=> __('Filter',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_ref'=> array(
		'type'=> 'text',
		'label'=> __('Ref',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_max_age'=> array(
		'type'=> 'text',
		'label'=> __('Max Age',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	
	'activity_linktarget'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'_blank', 'label'=>__('Blank',$this->plugin_text_domain)),
			array('value'=>'_top', 'label'=>__('Top',$this->plugin_text_domain)),							
			array('value'=>'_parent', 'label'=>__('Parent',$this->plugin_text_domain)),				
		),
		'label'=> __('Links Target',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_width'=> array(
		'type'=> 'text',
		'label'=> __('Width of box',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	
	'activity_height'=> array(
		'type'=> 'text',
		'label'=> __('Height of box',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_header'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Show Header ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_recommendation'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Recommendations',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_colorscheme'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'light', 'label'=>__('light',$this->plugin_text_domain)),
			array('value'=>'dark', 'label'=>__('Dark',$this->plugin_text_domain)),							
		),
		'label'=> __('Colors',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_font'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'arial', 'label'=>__('Arial',$this->plugin_text_domain)),
			array('value'=>'lucida grande', 'label'=>__('Lucida grande',$this->plugin_text_domain)),
			array('value'=>'segoe ui', 'label'=>__('Segoe ui',$this->plugin_text_domain)),
			array('value'=>'tahoma', 'label'=>__('Tahoma',$this->plugin_text_domain)),
			array('value'=>'trebuchet ms', 'label'=>__('Trebuchet ms',$this->plugin_text_domain)),
			array('value'=>'verdana', 'label'=>__('Verdana',$this->plugin_text_domain))							
		),
		'label'=> __('Fonts',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'activity_border_color'=> array(
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
			<div class="well">'.$this->get_the_activity_box().'</div>
			<h1>'.__('Options List',$this->plugin_text_domain).'</h1>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<tr>
						<th>Option</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
					<tr><td>domain</td><td>string</td></tr>
					<tr><td>width</td><td>number</td></tr>
					<tr><td>height</td><td>number</td></tr>
					<tr><td>colorscheme</td><td>light or dark</td></tr>
					<tr><td>fonts</td><td>string</td></tr>
					<tr><td>border_color</td><td>hexadecimal string (ex: #ffffff for white)</td></tr>
					<tr><td>recommendations</td><td>0 or 1</td></tr>
					<tr><td>header</td><td>0 or 1</td></tr>
					<tr><td>type</td><td>xfbml or iframe or html5</td></tr>
					<tr><td>max_age</td><td>string</td></tr>
					<tr><td>ref</td><td>string</td></tr>
					<tr><td>linktarget</td><td>_blank or _top or _parent</td></tr>
					<tr><td>filter</td><td>string</td></tr>
				</tbody>
				<tfoot>
					<th colspan="2">[AWD_activitybox option="value"]</th>
				</tfoot>
			</table>
		'
	)
);
?>