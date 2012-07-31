<?php
/*
*
* Fields Like button Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$fields['box'] = array(
	'title_config' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Configure the comments box',$this->plugin_text_domain).'</h1>
		'
	),
	
	'before_url' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'url'=> array(
		'type'=> 'text',
		'label'=> __('Default Url',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	
	'after_url' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	
	'before_config' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'type'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'xfbml', 'label'=>__('Xfbml',$this->plugin_text_domain)),							
			array('value'=>'html5', 'label'=>__('html5',$this->plugin_text_domain)),				
		),
		'label'=> __('Type',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	
	'num_posts'=> array(
		'type'=> 'text',
		'label'=> __('Nb of comments',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'mobile'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Mobile version',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'after_config' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'before_on_posts' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'on_pages'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Add Comments to pages',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'on_posts'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Add Comments to posts',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'on_custom_post_types'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Add Comments to custom posts',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'after_on_posts' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'before_config2' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'exclude_post_id'=> array(
		'type'=> 'text',
		'label'=> __('Exclude Posts or Pages ID (example: 12,46,234)',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'width'=> array(
		'type'=> 'text',
		'label'=> __('Width',$this->plugin_text_domain),
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
	
	'after_config2' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'preview' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Preview',$this->plugin_text_domain).'</h1>			
			<div class="well">'.$this->get_the_comments_box("",array("width"=>"420")).'</div> 
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
					<tr><td>nb</td><td>number</td></tr>
					<tr><td>colorscheme</td><td>light or dark</td></tr>
					<tr><td>mobile</td><td>0 or 1</td></tr>
					<tr><td>type</td><td>xfbml or iframe or html5</td></tr>
				</tbody>
				<tfoot>
					<th colspan="2">[AWD_comments option="value"]</th>
				</tfoot>
			</table>  
		'
	)
);
?>