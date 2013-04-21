<?php
/**
 * 
 * @author alexhermann
 *
 */

$fields = array();
$list_menu_plugins = array();
require(dirname(dirname(__FILE__)).'/forms/plugins_menu.php');
require(dirname(dirname(__FILE__)).'/forms/likebutton.php');
require(dirname(dirname(__FILE__)).'/forms/likebox.php');
require(dirname(dirname(__FILE__)).'/forms/activitybox.php');
require(dirname(dirname(__FILE__)).'/forms/shared_activitybox.php');
require(dirname(dirname(__FILE__)).'/forms/loginbutton.php');
require(dirname(dirname(__FILE__)).'/forms/commentsbox.php');

$fields = apply_filters('AWD_facebook_plugins_form', $fields);
if(!is_array($fields)){
	$fields = array();
}
$list_menu_plugins = apply_filters('AWD_facebook_plugins_menu', $list_menu_plugins);
if(!is_array($list_menu_plugins)){
	$list_menu_plugins = array();
}
$form = new AWD_facebook_form('form_settings', 'POST', $this->get_current_url(), $this->plugin_option_pref);
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
			
				<div id="likebutton_settings" class="tab-pane">
					<?php 					
					if(isset($fields['likebutton']) && is_array($fields['likebutton'])){
						echo $form->proccessFields('likebutton',$fields['likebutton']);
					}
					?>
				</div>
				
				<div id="likebox_settings" class="tab-pane">
					<?php 					
					if(isset($fields['likebox']) && is_array($fields['likebox'])){						
						echo $form->proccessFields('likebox',$fields['likebox']); 
					}
					?>
				</div>
				
				<div id="activity_settings" class="tab-pane">				
					<?php 
					if(isset($fields['activitybox']) && is_array($fields['activitybox'])){
						echo $form->proccessFields('activitybox',$fields['activitybox']);
					}
					?>
				</div>

				<div id="shared_activity_settings" class="tab-pane">				
					<?php 
					if($this->options['connect_enable'] == 1){
						if(isset($fields['shared_activitybox']) && is_array($fields['shared_activitybox'])){
							echo $form->proccessFields('shared_activitybox',$fields['shared_activitybox']);
						}
					}else{
						$this->templateManager->displayMessage(__('You must enable FB Connect and set parameters in settings of the plugins',$this->ptd), 'error');
					}
					?>
				</div>
				
				
				<div id="loginbutton_settings" class="tab-pane">
					<?php 
					if($this->options['connect_enable'] == 1){
						if(isset($fields['loginbutton']) && is_array($fields['loginbutton'])){
							echo $form->proccessFields('loginbutton',$fields['loginbutton']);
						}
					}else{
						$this->templateManager->displayMessage(__('You must enable FB Connect and set parameters in settings of the plugins',$this->ptd), 'error');
					}
					?>
				</div>
				
				<div id="comments_settings" class="tab-pane">
					<?php
					$message = '<i class="icon-warning-sign"></i> '.__('The form place depend on how your form theme is coded. Maybe some places will not work with your theme.',$this->ptd);
					$this->templateManager->displayMessage($message, 'info');
					
					if(isset($fields['commentsbox']) && is_array($fields['commentsbox'])){
						echo $form->proccessFields('commentsbox',$fields['commentsbox']);
					}
					?>
				</div>
				
				<?php
				//Plugins sections
				$plugin_fields = $fields;
				unset($plugin_fields['commentsbox']);
				unset($plugin_fields['loginbutton']);
				unset($plugin_fields['likebox']);
				unset($plugin_fields['likebutton']);
				unset($plugin_fields['activitybox']);
				foreach($plugin_fields as $plugin=>$fields)
				{
					?>
					<div id="<?php echo $plugin ?>_settings" class="tab-pane">
						<?php
						if(isset($fields) && is_array($fields)){
							echo $form->proccessFields($plugin,$fields);
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
			<a href="#" id="submit_settings" class="btn btn-primary" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Saving settings...',$this->ptd); ?>"><i class="icon-cog icon-white"></i> <?php _e('Save all settings',$this->ptd); ?></a>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!',$this->ptd); ?></a>
		</div>

	<?php echo $form->end(); ?>

</div>