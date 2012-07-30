<?php
/*
*
* Options Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/

?>
<div id="div_options_content">
	<div id="settings_ogp" class="tabbable tabs-left">
		<div class="tab-content">
			<div id="ogtags_objects">
				<h1><?php _e('Create Objects',$this->plugin_text_domain); ?></h1>
				<?php $ogp_objects = apply_filters('AWD_facebook_ogp_objects', $this->options['opengraph_objects']); ?>
				<table class="table table-bordered awd_list_opengraph_object">
					<thead>
						<th>Title</th>
						<th><span class="pull-right">Actions</span></th>
					</thead>
					<tbody class="content">
					<?php 
					if(is_array($ogp_objects) && count($ogp_objects)){
						foreach($ogp_objects as $ogp_object){
							echo $this->get_open_graph_object_list_item($ogp_object);
						}
					}
					echo '<tr class="awd_no_objects '.(is_array($ogp_objects) && count($ogp_objects) ? 'hidden' : '').'">
							<td colspan="2"><p class="alert alert-warning">'.__('No Object found',$this->plugin_text_domain).'</p></td>
						  </tr>';
					?>
					</tbody>
					</tfoot>
						<tr><td colspan="2"><button class="btn btn-success pull-right show_ogp_form" data-loading-text="<?php _e('Editing...',$this->plugin_text_domain); ?>"><i class="icon-plus icon-white"></i> <?php _e('Add an object',$this->plugin_text_domain); ?></button></td></tr>
					</tfoot>
				</table>
				
				<div class="hidden awd_ogp_form well">
				</div>
				
				<h1><?php _e('Define Objects relation',$this->plugin_text_domain); ?></h1>
				<div class="alert alert-info">
					<?php _e('Select the object to use with type of pages.',$this->plugin_text_domain); ?>
				</div>
				<div class="awd_ogp_links">
					<?php echo $this->get_open_graph_object_links_form(); ?>
				</div>
			</div>
		
			<?php
			
			/*
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
					}
				}else{
					echo '<div class="alert alert-warning"><p>'.__('There is no custom post types',$this->plugin_text_domain).'</p></div>';
				}
				?>
			</div>
			<?php
			$taxonomies = get_taxonomies(array('public'=> true,'show_ui'=>true),'objects');
			?>
			<div id="ogtags_taxonomies" class="tab-pane">
				<?php 
				if(!empty($taxonomies)){
					foreach($taxonomies as $taxonomie_name=>$tax_values){
					}
				}else{
					echo '<div class="alert alert-warning"><p>'.__('There is no Taxonomies',$this->plugin_text_domain).'</p></div>';
				}
				?>
			</div>
			*/ 
			?>
		</div>
	</div>
	<div class="form-actions">
		<a href="#" id="submit_ogp" class="btn btn-primary" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Saving settings...',$this->plugin_text_domain); ?>"><i class="icon-cog icon-white"></i> <?php _e('Save all settings',$this->plugin_text_domain); ?></a>
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!',$this->plugin_text_domain); ?></a>
	</div>
</div>