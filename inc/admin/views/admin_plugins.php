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
require_once(dirname(dirname(__FILE__)).'/model/admin_plugins_menu.php');
require_once(dirname(dirname(__FILE__)).'/model/like_button.php');
require_once(dirname(dirname(__FILE__)).'/model/like_box.php');

$fields = apply_filters('AWD_facebook_plugins', $fields);
if(!is_array($fields)){
	$fields = array();
}
$list_menu_plugins = apply_filters('AWD_facebook_list_plugins_menu', $list_menu_plugins);
if(!is_array($list_menu_plugins)){
	$list_menu_plugins = array();
}
$form = new AWD_facebook_form('form_settings', 'POST', '', $this->plugin_option_pref);
?>
<div id="div_options_content">

	<?php echo $form->start(); ?>

		<div id="settings_plugins" class="tabbable tabs-left">
			
			<?php
			if(count($list_menu_plugins)){ ?>
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
					<?php echo $form->proccessFields($fields['like_button']); ?>
				</div>
 
				<div id="like_box_settings" class="tab-pane">
					<p class="alert alert-info"><?php _e('The like box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></p>
					<?php echo $form->proccessFields($fields['like_box']); ?>
				</div>
				
			
			<div id="activity_settings" class="tab-pane">
			    <p class="alert alert-info"><?php _e('The activity box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></p>
				
                    
                    	
							<?php echo _e('Type',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_type'); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_xfbml" name="<?php echo $this->plugin_option_pref; ?>activity_type" value="xfbml" <?php if($this->options['activity_type'] == 'xfbml') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_xfbml"><?php _e('XFBML',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_iframe" name="<?php echo $this->plugin_option_pref; ?>activity_type" value="iframe" <?php if($this->options['activity_type'] == 'iframe') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_iframe"><?php _e('IFRAME',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_html5" name="<?php echo $this->plugin_option_pref; ?>activity_type" value="html5" <?php if($this->options['activity_type'] == 'html5') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_html5"><?php _e('HTML5',$this->plugin_text_domain);?></label>
							
						
                        
                            <?php _e('Domain',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_domain'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_domain" name="<?php echo $this->plugin_option_pref; ?>activity_domain" value="<?php echo $this->options['activity_domain']; ?>" size="30"/>
                            
                        
                        
                            <?php _e('Filter',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_filter'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_filter" name="<?php echo $this->plugin_option_pref; ?>activity_filter" value="<?php echo $this->options['activity_filter']; ?>" size="30"/>
                            
                        
                        
                            <?php _e('Ref',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_ref'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_ref" name="<?php echo $this->plugin_option_pref; ?>activity_ref" value="<?php echo $this->options['activity_ref']; ?>" size="30"/>
                            
                        
                         
                            <?php _e('Max Age',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_max_age'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_max_age" name="<?php echo $this->plugin_option_pref; ?>activity_max_age" value="<?php echo $this->options['activity_max_age']; ?>" size="30"/>
                            
                        
                        
							<?php echo _e('Link target',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_linktarget'); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_linktarget_blank" name="<?php echo $this->plugin_option_pref; ?>activity_linktarget" value="_blank" <?php if($this->options['activity_linktarget'] == '_blank') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_linktarget_blank"><?php _e('Blank',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);; ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_linktarget_top" name="<?php echo $this->plugin_option_pref; ?>activity_linktarget" value="_top" <?php if($this->options['activity_linktarget'] == '_top') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_linktarget_top"><?php _e('Top',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_linktarget_parent" name="<?php echo $this->plugin_option_pref; ?>activity_linktarget" value="_parent" <?php if($this->options['activity_linktarget'] == '_parent') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_linktarget_parent"><?php _e('Parent',$this->plugin_text_domain);?></label>
							
						
                        
                            <?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_width" name="<?php echo $this->plugin_option_pref; ?>activity_width" value="<?php echo $this->options['activity_width']; ?>" size="6" />
                            
                        
                        
                            <?php _e('Height of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_height" name="<?php echo $this->plugin_option_pref; ?>activity_height" value="<?php echo $this->options['activity_height']; ?>" size="6" />
                            
                        
                        
                            <?php _e('Show Header ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('show_header'); ?>
                            
                                <input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_header_on" name="<?php echo $this->plugin_option_pref; ?>activity_header" value="1" <?php if($this->options['activity_header'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_header_on"><?php _e('Yes',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);  ?></label> 
                                <input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_header_off" name="<?php echo $this->plugin_option_pref; ?>activity_header" value="0" <?php if($this->options['activity_header'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_header_off"><?php echo _e('No',$this->plugin_text_domain);?></label>
                            
                        
                        
                            <?php _e('Colorscheme of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?>
                            
                                <input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_on" name="<?php echo $this->plugin_option_pref; ?>activity_colorscheme" value="light" <?php if($this->options['activity_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_on"><?php _e('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
                                <input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_off" name="<?php echo $this->plugin_option_pref; ?>activity_colorscheme" value="dark" <?php if($this->options['activity_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_off"><?php _e('Dark',$this->plugin_text_domain); ?></label>
                            
                        
                        
                            <?php _e('Font',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_font'); ?>
                            
                                <select id="<?php echo $this->plugin_option_pref; ?>activity_font" name="<?php echo $this->plugin_option_pref; ?>activity_font"  onchange="onchange_uiSelect(this.id);">
                                    <option value="arial" <?php if($this->options['activity_font'] == "arial") echo 'selected="selected"'; ?> >Arial</option>
                                    <option value="lucida grande" <?php if($this->options['activity_font'] == "lucida grande") echo 'selected="selected"'; ?> >Lucida grande</option>
                                    <option value="segoe ui" <?php if($this->options['activity_font'] == "segoe ui") echo 'selected="selected"'; ?> >Segoe ui</option>
                                    <option value="tahoma" <?php if($this->options['activity_font'] == "tahoma") echo 'selected="checked"'; ?> >Tahoma</option>
                                    <option value="trebuchet ms" <?php if($this->options['activity_font'] == "trebuchet ms") echo 'selected="selected"'; ?> >Trebuchet ms</option>
                                    <option value="verdana" <?php if($this->options['activity_font'] == "verdana") echo 'selected="selected"'; ?> >Verdana</option>
                                </select>
                           
                        
                        
                            <?php _e('Border color',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_border'); ?>
                            
						        <input type="text" id="<?php echo $this->plugin_option_pref; ?>activity_border_color" name="<?php echo $this->plugin_option_pref; ?>activity_border_color" value="<?php echo $this->options['activity_border_color']; ?>" size="10" />
                            
                        
                        
                            <?php _e('Show Recommendations ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_recommendation'); ?>
                            
                                <input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_recommendations_on" name="<?php echo $this->plugin_option_pref; ?>activity_recommendations" value="1" <?php if($this->options['activity_recommendations'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_recommendations_on"><?php _e('Yes',$this->plugin_text_domain); ?></label>
                                <input type="radio" id="<?php echo $this->plugin_option_pref; ?>activity_recommendations_off" name="<?php echo $this->plugin_option_pref; ?>activity_recommendations" value="0" <?php if($this->options['activity_recommendations'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_recommendations_off"><?php _e('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
                            
                        
						
							
						
						
							
						
						
							
						        <?php echo $this->get_the_activity_box(); ?>
								
								<div class="awd_pre" style="text-align:left;">
									<strong>Shortcode: [AWD_activitybox]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_activity').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
									
									<div id="egoptions_activity"  class="hidden">
                                        Options:
                                        * domain (string)
                                        * width (number)
                                        * colorscheme (light or dark)
                                        * faces (0 or 1)
                                        * height (number)
                                        * type (xfbml or iframe or html5)
                                        * font (string)
                                        * border_color (ex: #ffffff for white)
                                        * header (0 or 1)
                                        * recommendations (0 or 1)
                                        * ref (string)
                                        * filter (string)
                                        * max_age (number 1-180)
                                    </div>
								</div>
							
						
                    					
			   
			</div>
			<?php
			/**
			* login button settings
			*/
			?>
			<div id="login_button_settings" class="tab-pane">
				<?php
				//if FB connect enable
				if($this->options['connect_enable'] == 1){
				?>
					
						
							
								<?php _e('Display the button on the login page (wp-login.php) ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_display_on_login_page'); ?>
								
									<input type="radio" id="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_on" name="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page" value="1" <?php if($this->options['login_button_display_on_login_page'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_on"><?php _e('Yes',$this->plugin_text_domain); ?></label> 
									<input type="radio" id="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_off" name="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page" value="0" <?php if($this->options['login_button_display_on_login_page'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_off"><?php _e('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								
							
							
								<?php _e('Show Profile picture ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_profile_picture'); ?>
								
									<input type="radio" id="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_on" name="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture" value="1" <?php if($this->options['login_button_profile_picture'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_on"><?php _e('Yes',$this->plugin_text_domain); ?></label> 
									<input type="radio" id="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_off" name="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture" value="0" <?php if($this->options['login_button_profile_picture'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_off"><?php _e('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								
							
							
								<?php _e('Width of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?>
								
									<input type="text" id="<?php echo $this->plugin_option_pref; ?>login_button_width" name="<?php echo $this->plugin_option_pref; ?>login_button_width" value="<?php echo $this->options['login_button_width']; ?>" size="6" />
								
							
							
								<?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?>
								
									<input type="radio" id="<?php echo $this->plugin_option_pref; ?>login_button_faces_on" name="<?php echo $this->plugin_option_pref; ?>login_button_faces" value="1" <?php if($this->options['login_button_faces'] == '1') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_faces_on"><?php _e('Yes',$this->plugin_text_domain); ?></label> 
									<input type="radio" id="<?php echo $this->plugin_option_pref; ?>login_button_faces_off" name="<?php echo $this->plugin_option_pref; ?>login_button_faces" value="0" <?php if($this->options['login_button_faces'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_faces_off"><?php _e('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								
							
							
								<?php _e('Max Rows (only if show faces = Yes)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_maxrow'); ?>
								
									<input type="text" id="<?php echo $this->plugin_option_pref; ?>login_button_maxrow" name="<?php echo $this->plugin_option_pref; ?>login_button_maxrow" value="<?php echo $this->options['login_button_maxrow']; ?>" size="6" />
								
							
							
								<?php _e('Logout Phrase',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_logout'); ?>
								
									<input type="text" id="<?php echo $this->plugin_option_pref; ?>login_button_logout_value" name="<?php echo $this->plugin_option_pref; ?>login_button_logout_value" value="<?php echo $this->options['login_button_logout_value']; ?>" size="30" />
								
							
							
								<?php _e('Redirect url after login',$this->plugin_text_domain); ?>. <?php _e('You can use pattern %BLOG_URL%. Default: current url',$this->plugin_text_domain); ?>
								
									<input type="text" id="<?php echo $this->plugin_option_pref; ?>login_button_login_url" name="<?php echo $this->plugin_option_pref; ?>login_button_login_url" value="<?php echo $this->options['login_button_login_url']; ?>" size="30" />
								
							
							
								<?php _e('Redirect url after logout',$this->plugin_text_domain); ?>. <?php _e('You can use pattern %BLOG_URL%. Default: current url',$this->plugin_text_domain); ?>
								
									<input type="text" id="<?php echo $this->plugin_option_pref; ?>login_button_logout_url" name="<?php echo $this->plugin_option_pref; ?>login_button_logout_url" value="<?php echo $this->options['login_button_logout_url']; ?>" size="30" />
								
							
							
								<?php _e('Button Image',$this->plugin_text_domain); ?>
								
									<input type="text" id="<?php echo $this->plugin_option_pref; ?>login_button_image" name="<?php echo $this->plugin_option_pref; ?>login_button_image" value="<?php echo $this->options['login_button_image']; ?>" size="30" /><img id="<?php echo $this->plugin_option_pref; ?>login_button_upload_image" src="<?php echo $this->plugin_url_images; ?>upload_image.png" alt="<?php _e('Upload',$this->plugin_text_domain); ?>" class="AWD_button_media"/>
								
							
							
								<?php _e('Custom Css',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_css'); ?>
								
									<textarea rows="10" class="uiTextarea" cols="35" id="<?php echo $this->plugin_option_pref; ?>login_button_css" name="<?php echo $this->plugin_option_pref; ?>login_button_css"><?php echo $this->options['login_button_css']; ?></textarea>
								
							
							
								
							
							
								
							
							
								
									<?php 
									//echo the button or profile
									$fcbk_content = '';
									$fcbk_content = $this->get_the_login_button();
									echo $fcbk_content;
									?>										
									
									<div class="awd_pre" style="text-align:left;">
										<strong>Shortcode: [AWD_loginbutton]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_loginbutton').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
										
										<div id="egoptions_loginbutton"  class="hidden">
											Options:
											* profile_picture (0 or 1)
											* width (number)
											* faces (0 or 1)
											* maxrow (number)
											* logout_value (string)
											* logout_url (string)
										</div>
									</div>
								
							
						
					
					<?php
				}else{
					echo '<div class="ui-state-error">'.__('You must enable FB Connect and set parameters in settings of the plugins',$this->plugin_text_domain).'</div>';
				}
				?>
			</div>
			<?php
			/**
			* Comments settings
			*/
			?>
			<div id="comments_settings" class="tab-pane">
					<p class="alert alert-info"><?php _e('All that settings are defaults, you can redefine them in shortcodes, and themes functions',$this->plugin_text_domain); ?></p>
				<p class="alert alert-info"><?php _e('Note: Your themes must use the action "do_action("comment_form_after");" or the function "commnent_form();" to work. (look in your theme, in comments.php file)',$this->plugin_text_domain); ?></p>
				
					
						
							<?php _e('URL to comment on',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_url'); ?>
							
								<input type="text" id="<?php echo $this->plugin_option_pref; ?>comments_url" name="<?php echo $this->plugin_option_pref; ?>comments_url" value="<?php echo $this->options['comments_url']; ?>" size="30" />
							
						
						
							<?php echo _e('Type',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_type'); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_xfbml" name="<?php echo $this->plugin_option_pref; ?>comments_type" value="xfbml" <?php if($this->options['comments_type'] == 'xfbml') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>comments_xfbml"><?php _e('XFBML',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_html5" name="<?php echo $this->plugin_option_pref; ?>comments_type" value="html5" <?php if($this->options['comments_type'] == 'html5') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>comments_html5"><?php _e('HTML5',$this->plugin_text_domain);?></label>
							
						
						
							<?php _e('Number of posts',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_nb'); ?>
							
								<input type="text" id="<?php echo $this->plugin_option_pref; ?>comments_nb" name="<?php echo $this->plugin_option_pref; ?>comments_nb" value="<?php echo $this->options['comments_nb']; ?>" size="6" />
							
						
						
							<?php _e('Mobile version ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_mobile'); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_mobile_on" name="<?php echo $this->plugin_option_pref; ?>comments_mobile" value="1" <?php if($this->options['comments_mobile'] == '1') echo 'checked="checked"'; ?> /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_mobile_on"><?php _e('Yes',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_mobile_off" name="<?php echo $this->plugin_option_pref; ?>comments_mobile" value="0" <?php if($this->options['comments_mobile'] == '0') echo 'checked="checked"'; ?> /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_mobile_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							
						
						
							<?php _e('Add Comments Box to pages',$this->plugin_text_domain); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_on_pages_on" name="<?php echo $this->plugin_option_pref; ?>comments_on_pages" value="1" <?php if($this->options['comments_on_pages'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_pages').slideDown('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_pages_on"><?php _e('Yes',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_on_pages_off" name="<?php echo $this->plugin_option_pref; ?>comments_on_pages" value="0" <?php if($this->options['comments_on_pages'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_pages').slideUp('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_pages_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							
						
						
							<?php _e('Add Comments Box to posts',$this->plugin_text_domain); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_on_posts_on" name="<?php echo $this->plugin_option_pref; ?>comments_on_posts" value="1" <?php if($this->options['comments_on_posts'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_posts').slideDown('fast');" /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_posts_on"><?php _e('Yes',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_on_posts_off" name="<?php echo $this->plugin_option_pref; ?>comments_on_posts" value="0" <?php if($this->options['comments_on_posts'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_posts').slideUp('fast');" /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_posts_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							
						
						
							<?php _e('Add Comments Box to custom post types',$this->plugin_text_domain); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_on" name="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types" value="1" <?php if($this->options['comments_on_custom_post_types'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_custom_post_types').slideDown('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_on"><?php _e('Yes',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_off" name="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types" value="0" <?php if($this->options['comments_on_custom_post_types'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_custom_post_types').slideUp('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							
						
						
							<?php _e('Exclude Posts or Pages ID (example: 12,46,234)',$this->plugin_text_domain); ?>
							
								<input type="text" id="<?php echo $this->plugin_option_pref; ?>comments_exclude_post_id" name="<?php echo $this->plugin_option_pref; ?>comments_exclude_post_id" value="<?php echo $this->options['comments_exclude_post_id']; ?>" size="30" />
							
						
						
							<?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?>
							
								<input type="text" id="<?php echo $this->plugin_option_pref; ?>comments_width" name="<?php echo $this->plugin_option_pref; ?>comments_width" value="<?php echo $this->options['comments_width']; ?>" size="6" />
							
						
						
							<?php _e('Color Scheme',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?>
							
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_1" name="<?php echo $this->plugin_option_pref; ?>comments_colorscheme" value="light" <?php if($this->options['comments_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_1"><?php _e('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_2" name="<?php echo $this->plugin_option_pref; ?>comments_colorscheme" value="dark" <?php if($this->options['comments_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_2"><?php _e('Dark',$this->plugin_text_domain); ?></label>
						
							
						
						
							
								<?php 
								//echo the comments box
								$fcbk_content = '';
								$fcbk_content = $this->get_the_comments_box("",array("comments_width"=>"420"));
								echo $fcbk_content;
								?>										
								
								<div class="awd_pre" style="text-align:left;">
									<strong>Shortcode: [AWD_comments]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_comments').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
									
									<div id="egoptions_comments"  class="hidden">
										Options:
										* url (string)
											* nb (number)
										* width (number)
										* colorscheme (light or dark)
										* mobile (true or false)
										* type (xfbml or html5)
									</div>
								</div>
					  
			</div> 
			
			<?php 
			//Add a hook to alloaw plugins to add a section here
			//do_action("AWD_facebook_plugins_form");
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