<?php
/*
*
* Fields Like button Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$fields['like_button'] = array(
	'title_config' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Configure the button',$this->plugin_text_domain).'</h1>
		'
	),
	
	'before_config' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'like_button_font'=> array(
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
	
	'like_button_action'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'like', 'label'=>__('Like',$this->plugin_text_domain)),
			array('value'=>'recommend', 'label'=>__('Recommend',$this->plugin_text_domain))						
		),
		'label'=> __('Action',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_layout'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'standard', 'label'=>__('Standard',$this->plugin_text_domain)),
			array('value'=>'button_count', 'label'=>__('Button Count',$this->plugin_text_domain)),							
			array('value'=>'box_count', 'label'=>__('Box Count',$this->plugin_text_domain))					
		),
		'label'=> __('Layout style',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_type'=> array(
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
	
	'like_button_send'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Send button ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2','disabled'=>($this->options['like_button_type'] == "iframe" ? 'disabled' : ''))
	),
	
	'like_button_colorscheme'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'light', 'label'=>__('light',$this->plugin_text_domain)),
			array('value'=>'dark', 'label'=>__('Dark',$this->plugin_text_domain)),							
		),
		'label'=> __('Colors',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_faces'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Show Faces ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_width'=> array(
		'type'=> 'text',
		'label'=> __('Width of button',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_height'=> array(
		'type'=> 'text',
		'label'=> __('Height of button',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_ref'=> array(
		'type'=> 'text',
		'label'=> __('Ref',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'after_config' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'title_usage' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Define a default usage',$this->plugin_text_domain).'</h1>
		'
	),
	
	'before_url' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'like_button_url'=> array(
		'type'=> 'text',
		'label'=> __('Default Url to like',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'after_url' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'before_on_pages' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		'
	),
	
	'like_button_on_pages'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Display on pages ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_place_on_pages'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'top', 'label'=>__('Top',$this->plugin_text_domain)),
			array('value'=>'bottom', 'label'=>__('Bottom',$this->plugin_text_domain)),							
			array('value'=>'both', 'label'=>__('Both',$this->plugin_text_domain)),							
		),
		'label'=> __('Where ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2', 'disabled'=>($this->options['like_button_on_pages'] == "0" ? 'disabled' : ''))
	),
	
	'after_on_pages' => array(
		'type'=>'html',
		'html'=> '
			</div>
		'
	),
	
	'before_on_posts' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		',
	),
	
	'like_button_on_posts'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('Display on posts ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_place_on_posts'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'top', 'label'=>__('Top',$this->plugin_text_domain)),
			array('value'=>'bottom', 'label'=>__('Bottom',$this->plugin_text_domain)),							
			array('value'=>'both', 'label'=>__('Both',$this->plugin_text_domain)),							
		),
		'label'=> __('Where ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2', 'disabled'=>($this->options['like_button_on_posts'] == "0" ? 'disabled' : ''))
	),
	
	'after_on_posts' => array(
		'type'=>'html',
		'html'=> '
				</div>
		',
	),
	
	'before_on_posts_types' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		',
	),
	
	'like_button_on_custom_post_types'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'0', 'label'=>__('No',$this->plugin_text_domain)),
			array('value'=>'1', 'label'=>__('Yes',$this->plugin_text_domain)),							
		),
		'label'=> __('On custom posts ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2')
	),
	
	'like_button_place_on_custom_post_types'=> array(
		'type'=> 'select',
		'options' => array(
			array('value'=>'top', 'label'=>__('Top',$this->plugin_text_domain)),
			array('value'=>'bottom', 'label'=>__('Bottom',$this->plugin_text_domain)),							
			array('value'=>'both', 'label'=>__('Both',$this->plugin_text_domain)),							
		),
		'label'=> __('Where ?',$this->plugin_text_domain),
		'class'=>'span2',
		'attr'=> array('class'=>'span2', 'disabled'=>($this->options['like_button_on_custom_post_types'] == "0" ? 'disabled' : ''))
	),
	
	'after_on_posts_types' => array(
		'type'=>'html',
		'html'=> '
				</div>
		',
	),
	
	'before_on_exclude' => array(
		'type'=>'html',
		'html'=> '
			<div class="row">
		',
	),

	'like_button_exclude_post_type'=> array(
		'type'=> 'text',
		'label'=> __('Exclude Post types',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'like_button_exclude_terms_slug'=> array(
		'type'=> 'text',
		'label'=> __('Exclude Categories or other terms',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'like_button_exclude_post_id'=> array(
		'type'=> 'text',
		'label'=> __('Exclude Posts or Pages ID',$this->plugin_text_domain),
		'class'=>'span4',
		'attr'=> array('class'=>'span4')
	),
	
	'after_exclude' => array(
		'type'=>'html',
		'html'=> '
				</div>
		',
	),
	
	'preview' => array(
		'type'=>'html',
		'html'=> '
			<h1>'.__('Preview',$this->plugin_text_domain).'</h1>			
			<div class="well">'.$this->get_the_like_button().'</div> 
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
					<tr><td>send</td><td>0 or 1</td></tr>
					<tr><td>width</td><td>number</td></tr>
					<tr><td>height</td><td>number</td></tr>
					<tr><td>colorscheme</td><td>light or dark</td></tr>
					<tr><td>faces</td><td>0 or 1</td></tr>
					<tr><td>fonts</td><td>string</td></tr>
					<tr><td>action</td><td>like or recommend</td></tr>
					<tr><td>layout</td><td>standard, box_count or button_count</td></tr>
					<tr><td>type</td><td>xfbml or iframe or html5</td></tr>
					<tr><td>ref</td><td>string</td></tr>
				</tbody>
				<tfoot>
					<th colspan="2">[AWD_likebutton option="value"]</th>
				</tfoot>
			</table>  
		'
	)
);
?>