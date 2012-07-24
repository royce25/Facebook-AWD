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
	<?php echo $form->start(); ?>
		<div id="settings" class="tabbable tabs-left">
			<ul id="settings_menu" class="nav nav-tabs">
				<li><a href="#general" data-toggle="tab">General</a></li>
				<li><a href="#opengraph" data-toggle="tab">OpenGraph</a></li>
				<li><a href="#fbconnect" data-toggle="tab">Facebook Connect</a></li>
				<li><a href="#managepages" data-toggle="tab">Manage Pages</a></li>
			</ul>
			<div class="tab-content">
				<div id="general" class="tab-pane">		
					<div class="row">
						<?php 
						echo $form->addInputText(__('App ID (facebook)',$this->plugin_text_domain).' '.$this->get_the_help('app_id'), 'app_id', $this->options['app_id'], 'span4', array('class'=>'span3'), 'icon-barcode');
						echo $form->addInputText(__('App SECRET KEY',$this->plugin_text_domain).' '.$this->get_the_help('app_secret_key'), 'app_secret_key', $this->options['app_secret_key'], 'span4', array('class'=>'span3'), 'icon-barcode'); 
						echo $form->addInputText(__('Admins IDs (facebook)',$this->plugin_text_domain).' '.$this->get_the_help('admins'), 'admins', $this->options['admins'], 'span4', array('class'=>'span3'), 'icon-user'); 
						?>
						<div class="span4">
							<div class="row">
								<?php 						
								echo $form->addInputText(__('Locale',$this->plugin_text_domain).' '.$this->get_the_help('locale'), 'locale', $this->options['locale'], 'span2', array('class'=>'span1'), 'icon-flag'); 
								?>
							</div>
						</div>
						<?php
							echo $form->addSelect(__('Mode Debug ?',$this->plugin_text_domain).' '.$this->get_the_help('debug_enable'), 'debug_enable', array(
								array('value'=>0, 'label'=>__('No',$this->plugin_text_domain)),
								array('value'=>1, 'label'=>__('Yes',$this->plugin_text_domain))									
							), $this->options['debug_enable'], 'span4', array('class'=>'span1'));
						?>
					</div>
					
				</div>
		
				<div id="opengraph" class="tab-pane">							
					<div class="row">
						<?php 
						echo $form->addSelect(__('Activate Open Graph ?',$this->plugin_text_domain).' '.$this->get_the_help('open_graph_enable'), 'open_graph_enable', array(
							array('value'=>0, 'label'=>__('No',$this->plugin_text_domain)),
							array('value'=>1, 'label'=>__('Yes',$this->plugin_text_domain).' '.__('(recommended)',$this->plugin_text_domain))									
						), $this->options['open_graph_enable'], 'span3', array('class'=>'span3'));
						?>
					</div>
				</div>
		
				<div id="fbconnect" class="tab-pane">								
					<div class="row">
						<?php 
						echo $form->addSelect(__('Activate FB Connect ?', $this->plugin_text_domain).' '.$this->get_the_help('connect_enable'),'connect_enable',array(
							array('value'=>0, 'label'=>__('No',$this->plugin_text_domain)),
							array('value'=>1, 'label'=>__('Yes',$this->plugin_text_domain))									
						),$this->options['connect_enable'],'span3',array('class'=>'span3'));
						
						echo $form->addSelect(__('Add FB avatar choice ?',$this->plugin_text_domain).' '.$this->get_the_help('connect_fbavatar'), 'connect_fbavatar', array(
							array('value'=>0, 'label'=>__('No',$this->plugin_text_domain)),
							array('value'=>1, 'label'=>__('Yes',$this->plugin_text_domain))									
						), $this->options['connect_fbavatar'], 'span3', array('class'=>'span3 depend_fb_connect', 'disabled'=> $this->options['connect_enable']== '0' ? 'disabled':''));
						?>
					</div>
					<div class="row">
						<?php
						echo $form->addInputText(__('Facebook Connect permissions',$this->plugin_text_domain).' '.$this->get_the_help('perms'), 'perms', $this->options['perms'], 'span3', array('class'=>'span3 depend_fb_connect', 'disabled'=> $this->options['connect_enable']== '0' ? 'disabled':'')); 
						
						echo $form->addInputText(__('Timeout Facebook connect API',$this->plugin_text_domain).' '.$this->get_the_help('timeout'), 'timeout', $this->options['timeout'], 'span3', array('class'=>'span3 depend_fb_connect', 'disabled'=> $this->options['connect_enable']== '0' ? 'disabled':''));
						?>
					</div>
				</div>
		
				<div id="managepages" class="tab-pane">
				<?php if($this->options['connect_enable'] == 0){ ?>
					<div class="alert alert-warning"><?php _e('Facebook connect is required to manage pages',$this->plugin_text_domain); ?></div>
				<?php }else{ ?>		
					<?php if($this->current_facebook_user_can('publish_stream')){ ?>
						<div class="alert alert-info"><?php _e('Publish Stream is enabled',$this->plugin_text_domain); ?></div>
					<?php }else{ ?>
						<a href="#" data-scope="email,publish_stream" class="get_permissions btn btn-info"><i class="icon-ok-sign icon-white"></i> <?php _e('Authorize App to publish on your pages',$this->plugin_text_domain); ?></a>
					<?php } ?>
				
					<?php if($this->current_facebook_user_can('manage_pages')){ ?>
						<div class="alert alert-info"><?php _e('Pages can be managed',$this->plugin_text_domain); ?>
						<a href="#" id="toogle_list_pages" class="btn btn-info"><i class="icon-check icon-white"></i> <?php _e('Select pages to link with Wordpress',$this->plugin_text_domain); ?></a>
						</div>
					<?php }else{ ?>
						<a href="#" data-scope="email,manage_pages" class="get_permissions btn btn-info"><i class="icon-ok-sign icon-white"></i> <?php _e('Authorize App to access your pages',$this->plugin_text_domain); ?></a>
					<?php } ?>
					<?php if($this->current_facebook_user_can('manage_pages')){ ?>
						<div class="toogle_fb_pages hidden well">
							<h2><?php _e('Check the page you want to sync with your blog.',$this->plugin_text_domain); ?></h2>
							<?php
							$fb_pages = $this->me['pages'];
							if(is_array($fb_pages) AND count($fb_pages)){
								echo '
								<table class="table table-striped">
									<tbody>';
									foreach($fb_pages as $fb_page){
										echo '
										<tr>
											<td><input value="1" type="checkbox" '.($this->options['fb_publish_to_pages'][$fb_page['id']] == 1 ? 'checked="checked";' : '').' name="'.$this->plugin_option_pref.'fb_publish_to_pages['.$fb_page['id'].']" id="fb_publish_to_pages'.$fb_page['id'].'" /></td>
											<td><a href="#" class="thumbnail"><img class="fb_pages_picto" src="http://graph.facebook.com/'.$fb_page['id'].'/picture" width="30" height="30" /></a></td>
											<td>'.$fb_page['name'].'</td>
											<td>'.$fb_page['id'].'</td>
											<td>'.$fb_page['category'].'</td>
										</tr>';
									}
								echo '</tbody>
								</table>';
							}
							?>
						</div>
					<?php } ?>
					<?php if($this->current_facebook_user_can('publish_stream')){ ?>
						<div class="row">
							<?php 
							if($this->current_facebook_user_can('manage_pages')){ 
								echo $form->addSelect(__('Auto publish post on Facebook pages ?',$this->plugin_text_domain).' '.$this->get_the_help('publish_to_pages'), 'publish_to_pages', array(
									array('value'=>0, 'label'=>__('No',$this->plugin_text_domain)),
									array('value'=>1, 'label'=>__('Yes',$this->plugin_text_domain))									
								), $this->options['publish_to_pages'], 'span3', array('class'=>'span3'));
							} 
							
							echo $form->addSelect(__('Auto publish post on Facebook profile ?',$this->plugin_text_domain).' '.$this->get_the_help('publish_to_profile'), 'publish_to_profile', array(
								array('value'=>0, 'label'=>__('No',$this->plugin_text_domain)),
								array('value'=>1, 'label'=>__('Yes',$this->plugin_text_domain))									
							), $this->options['publish_to_profile'], 'span3', array('class'=>'span3'));
							?>
						</div>
						<div class="row">
							<?php
							echo $form->addInputText(__('Default link action Text',$this->plugin_text_domain).' '.$this->get_the_help('publish_read_more_text'), 'publish_read_more_text', $this->options['publish_read_more_text'], 'span3', array('class' => 'span3', 'maxlengh'=>'25')); 
							?>
						</div>
					<?php } ?>
				<?php } ?>
				</div>
			</div>
		</div>
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		<div class="form-actions">
			<a href="#" id="submit_settings" class="btn btn-primary" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Saving settings...',$this->plugin_text_domain); ?>"><i class="icon-cog icon-white"></i> <?php _e('Save all settings',$this->plugin_text_domain); ?></a>
			<a href="#" id="reset_settings" class="btn btn-danger" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Waiting for your anwser',$this->plugin_text_domain); ?>"><i class="icon-trash icon-white"></i> <?php _e('Restore defaults settings',$this->plugin_text_domain); ?></a>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!',$this->plugin_text_domain); ?></a>
		</div>
	<?php 
	echo $form->end(); 
	
	//reset form
	$form_reset = new AWD_facebook_form('reset_settings', 'POST', '', $this->plugin_option_pref);
	echo $form_reset->start();
	wp_nonce_field($this->plugin_slug.'_reset_options',$this->plugin_option_pref.'_nonce_reset_options');
	echo $form_reset->end();
	?>
</div>
<div class="alert alert-error alert_reset_settings hidden alert-block">
	<a href="#" class="close reset_settings_dismiss">&times;</a>      
	<?php _e("Do you really want to reset all settings (AWD plugins and openGraph settings will be reset) ?",$this->plugin_text_domain); ?>
	<a href="#" class="btn btn-danger reset_settings_confirm"><?php _e("Restore", $this->plugin_text_domain); ?></a>  
</div>