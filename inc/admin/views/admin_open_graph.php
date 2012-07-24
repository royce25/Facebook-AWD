<?php
/*
*
* Options Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
?>
<?php
$form = new AWD_facebook_form('form_settings', 'POST', '', $this->plugin_option_pref);
?>
<div id="div_options_content">
		
		<div id="settings_opg" class="tabbable tabs-left">
			
			<ul id="settings_opg_menu" class="nav nav-tabs">
				<li><a href="#ogtags_objects" data-toggle="tab"><?php _e('Objects',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_frontpage" data-toggle="tab"><?php _e('Frontpage',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_pages" data-toggle="tab"><?php _e('Pages',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_posts" data-toggle="tab"><?php _e('Posts',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_archives" data-toggle="tab"><?php _e('Archives',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_author" data-toggle="tab"><?php _e('Authors',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_custom_posts" data-toggle="tab"><?php _e('Custom Post types',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_taxonomies" data-toggle="tab"><?php _e('Taxonomies',$this->plugin_text_domain); ?></a></li>
			</ul>
			
			<div class="tab-content">
				
				<div id="ogtags_objects" class="tab-pane">
					<h1><?php _e('Create objects to use in your posts',$this->plugin_text_domain); ?></h1>
					<?php $ogp_objects = apply_filters('AWD_facebook_ogp_objects', $this->options['ogp_objects']); ?>
					<table class="table table-bordered">
						<thead>
							<th>Title</th>
							<th>Actions</th>
						</thead>
						<tbody>
						<?php 
						if(is_array($ogp_object) && count($ogp_object)){
							foreach($ogp_objects as $ogp_object){
								echo '<tr>
									<td></td>
									<td></td>
								</tr>';
							}
						}else{
							echo '<tr>
									<td colspan="2">No objects found</td>
								</tr>';
						}
						?>
						</tbody>
					</table>
					
					
					
					
					<h2><?php _e('1. Create Default Object',$this->plugin_text_domain); ?></h2>

					<?php
					$object = array('title'=>'%TITLE%');
					
					$ogp = new OpenGraphProtocol();
					if(isset($object['locale']))
						$ogp->setLocale($object['locale']);
					if(isset($object['name']))
						$ogp->setSiteName($object['name']);
					if(isset($object['title']))
						$ogp->setTitle($object['title']);
					if(isset($object['description']))
						$ogp->setDescription($object['description']);
					if(isset($object['type']))
						$ogp->setType($object['type']);
					if(isset($object['url']))
						$ogp->setURL($object['url']);
					if(isset($object['determiner']))
						$ogp->setDeterminer($object['determiner']);
					if(isset($object['image']))
						$ogp->addImage($object['image']);
					if(isset($object['audio']))
						$ogp->addAudio($object['audio']);
					if(isset($object['video']))
						$ogp->addVideo($object['video']);
					
					$fields = $ogp->getClassVars();
					echo $form->start();
					
					?>
					<div class="row">
						<?php
						//title of object
						echo $form->addInputText('Title of object (only for reference)',  $field, $this->options[$field], 'span4', array('class'=>'span4'));
						//Locale
						$locales = $ogp->supported_locales();
						$_locales = array();
						foreach($locales as $locale => $label){ $_locales[] = array('value'=>$locale, 'label'=> $label ); }
						echo $form->addSelect(__('Locale',$this->plugin_text_domain), 'ogp_locale', $_locales, $ogp->getLocale(), 'span4', array('class'=>'span2'));					
						?>
					</div>
					<div class="row">
						<?php
						//Determiner
						echo $form->addInputText('The determiner',  $field, $ogp->getDeterminer(), 'span2', array('class'=>'span2'));
						//title of the page
						echo $form->addInputText('Title',  $field, $ogp->getTitle(), 'span4', array('class'=>'span4'));
						//type
						$types = $ogp->supported_types(true);
						foreach($types as $type){ $options[] = array('value'=>$type, 'label'=> ucfirst($type)); }
						echo $form->addSelect(__('Type',$this->plugin_text_domain).' '.$this->get_the_help('type'), 'type', $options, $ogp->gettype(), 'span2', array('class'=>'span2'));
						?>
					</div>
					<div class="row">
						<?php
						//Description
						echo $form->addInputText('Description',  'description', $ogp->getDescription(), 'span8', array('class'=>'span8'));
						?>
					</div>
					<div class="row">
						<?php
						//Site name
						echo $form->addInputText('Site Name', 'site_name', $ogp->getSiteName(), 'span4', array('class'=>'span4'));
						//Url
						echo $form->addInputText('Url',  'url', $ogp->getUrl(), 'span4', array('class'=>'span4'));
						?>
					</div>
					<?php
					echo $form->end();
					?>
					<h2><?php _e('2. Add Media to Object',$this->plugin_text_domain); ?></h2>
					<div class="row">
						<?php
						//echo $form->addMediaButton('Media url', 'media1', '','span8', array('class'=>'span6'), array('data-title'=>'Upload Media', 'data-type'=> 'image'), true);
						?>
						</div>
						<div class="btn-group">
							<button class="btn btn-mini btn"><i class="icon-picture"></i> Add an image</button>
							<button class="btn btn-mini btn"><i class="icon-film"></i> Add a video</button>
							<button class="btn btn-mini btn"><i class="icon-music"></i> Add a video</button>
						</div>				
					</div>
				
				
				
				
				
				
				
				
				
				<div id="ogtags_frontpage" class="tab-pane">
				</div>
				
				<div id="ogtags_pages" class="tab-pane">
				</div>
				
				<div id="ogtags_posts" class="tab-pane">
				</div>
				
				<div id="ogtags_archives" class="tab-pane">
				</div>

				<div id="ogtags_author" class="tab-pane">
				</div>
				<?php
				
				$postypes_media = get_post_types(array('label'=>'Media'),'objects');
				$postypes = get_post_types(array('show_ui'=>true),'objects');
				//if find attachement
				if(is_object($postypes_media['attachment']))
						$postypes['attachment'] = $postypes_media['attachment'];
								//remove page and post form custom
				unset($postypes['post']);
				unset($postypes['page']);
				?>
				<div id="ogtags_custom_posts" class="tab-pane">
					<?php 
					if(!empty($postypes)){
						foreach($postypes as $postypes_name=>$type_values){
							$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_custom_post_types_'.$postypes_name.'_';
							//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
							$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
							$meta['args']['help'] = 'custom_post_types';
							//to not call the accordion ui jquery
							$meta['args']['header'] = 'h3 class="tabs_in_tab"';
							echo '<h4><a href="#">'.$type_values->label.' ('.$type_values->name.')</a></h4>';
							echo '<div>';
							//	$this->open_graph_post_metas_form('',$meta);
							echo '</div>';
						}
					}else{
						echo '<div class="alert alert-warning AWD_message"><p>'.__('There is no custom post types',$this->plugin_text_domain).'</p></div>';
					}
					?>
				</div>
				<?php
				/**
				* Open graph custom posts settings
				*/
				$taxonomies = get_taxonomies(array('public'=> true,'show_ui'=>true),'objects');
				?>
				<div id="ogtags_taxonomies" class="tab-pane">
					<?php 
					if(!empty($taxonomies)){
						foreach($taxonomies as $taxonomie_name=>$tax_values){
							$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_taxonomies_'.$taxonomie_name.'_';
							//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
							$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
							$meta['args']['help'] = 'taxonomies';
							//to not call the accordion ui jquery
							$meta['args']['header'] = 'h3 class="tabs_in_tab"';
							echo '<h4><a href="#">'.$tax_values->label.' ('.$tax_values->name.')</a></h4>';
							echo '<div>';
							//	$this->open_graph_post_metas_form('',$meta);
							echo '</div>';
						}
					}else{
						echo '<div class="alert alert-warning AWD_message"><p>'.__('There is no Taxonomies',$this->plugin_text_domain).'</p></div>';
					}
					?>
				</div>
			</div>
		</div>
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		<div class="form-actions">
			<a href="#" id="submit_opg" class="btn btn-primary" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Saving settings...',$this->plugin_text_domain); ?>"><i class="icon-cog icon-white"></i> <?php _e('Save all settings',$this->plugin_text_domain); ?></a>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!',$this->plugin_text_domain); ?></a>
		</div>
</div>