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
$fields = array();
$list_menu_plugins = array();
require_once(dirname(dirname(__FILE__)).'/model/plugins_menu.php');
require_once(dirname(dirname(__FILE__)).'/model/like_button.php');
require_once(dirname(dirname(__FILE__)).'/model/like_box.php');
require_once(dirname(dirname(__FILE__)).'/model/activity_box.php');
require_once(dirname(dirname(__FILE__)).'/model/login_button.php');
require_once(dirname(dirname(__FILE__)).'/model/comments_box.php');

$fields = apply_filters('AWD_facebook_plugins_form', $fields);
if(!is_array($fields)){
	$fields = array();
}
$list_menu_plugins = apply_filters('AWD_facebook_plugins_menu', $list_menu_plugins);
if(!is_array($list_menu_plugins)){
	$list_menu_plugins = array();
}
$form = new AWD_facebook_form('form_settings', 'POST', '', $this->plugin_option_pref);
?>
<div id="div_options_content">
	
	<?php echo $form->start(); ?>
		
		<div id="settings_plugins" class="tabbable tabs-left">
			
			<?php if(count($list_menu_plugins)){ ?>
				<ul id="plugins_menu" class="nav nav-tabs">  	
					<?php 
					foreach($list_menu_plugins as $item_id => $label){
						echo '<li><a href="#'.$item_id.'" data-toggle="tab">'.$label.'</a></li>';
					}
					?>
				</ul>
			<?php } ?>
			
			
			<div class="tab-content">
			
				<div id="like_button_settings" class="tab-pane">
					<p class="alert alert-info"><?php _e('Settings are defaults, you can redefine them in shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></p>
					<?php 
					if(isset($fields['like_button']) && is_array($fields['like_button'])){
						echo $form->proccessFields($fields['like_button']);
					}
					?>
				</div>
				
				<div id="like_box_settings" class="tab-pane">
					<p class="alert alert-info"><?php _e('The like box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></p>
					<?php 
					if(isset($fields['like_box']) && is_array($fields['like_box'])){
						echo $form->proccessFields($fields['like_box']); 
					}
					?>
				</div>
				
				<div id="activity_settings" class="tab-pane">
					<p class="alert alert-info"><?php _e('The activity box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></p>
					<?php 
					if(isset($fields['activity_box']) && is_array($fields['activity_box'])){
						echo $form->proccessFields($fields['activity_box']);
					}
					?>
				</div>
				
				
				<div id="login_button_settings" class="tab-pane">
					<?php 
					if($this->options['connect_enable'] == 1){
						if(isset($fields['login_button']) && is_array($fields['login_button'])){
							echo $form->proccessFields($fields['login_button']);
						}
					}else{
						echo '<p class="alert alert-warning">'.__('You must enable FB Connect and set parameters in settings of the plugins',$this->plugin_text_domain).'</p>';
					}
					?>
				</div>
				
				<div id="comments_settings" class="tab-pane">
					<p class="alert alert-info">
						<?php _e('All that settings are defaults, you can redefine them in shortcodes, and themes functions',$this->plugin_text_domain); ?>
						<br />
						<i class="icon-warning-sign"></i> <?php _e('Your themes must use the action "do_action("comment_form_after");" or the function "commnent_form();" to work. (look in your theme, in comments.php file)',$this->plugin_text_domain); ?>
					</p>
					
					<?php
					if(isset($fields['comments_box']) && is_array($fields['comments_box'])){
						echo $form->proccessFields($fields['comments_box']);
					}
					?>
				</div>
				
				<?php
				//Plugins sections
				$plugin_fields = $fields;
				unset($plugin_fields['comments_box']);
				unset($plugin_fields['login_button']);
				unset($plugin_fields['like_box']);
				unset($plugin_fields['like_button']);
				unset($plugin_fields['activity_box']);
				foreach($plugin_fields as $plugin=>$fields)
				{
				//print_r($field);
					?>
					<div id="<?php echo $plugin ?>_settings" class="tab-pane">
						<?php
						if(isset($fields) && is_array($fields)){
							echo $form->proccessFields($fields);
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		
		<div class="form-actions">
			<a href="#" id="submit_settings" class="btn btn-primary"><i class="icon-cog icon-white"></i> <?php _e('Save all settings',$this->plugin_text_domain); ?></a>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!',$this->plugin_text_domain); ?></a>
		</div>

	<?php echo $form->end(); ?>

</div>
<?php
/**
* Javascript for admin
*/
?>
<script type="text/javascript">
	jQuery(document).ready( function($){
        $('#plugins_menu a:first').tab('show');
		$('#submit_settings').click(function(){
			$('#<?php echo $this->plugin_slug; ?>_form_settings').submit();
			return false;
		});
	});
</script>