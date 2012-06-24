/*
*
* JS AWD FCBK
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
function AWDFacebookAdmin($){

	this.reloadAppInfos = function(button)
	{
		$(button).button('loading');
		$.post(ajaxurl,{action:'get_app_infos_content'},function(data){	
			if(data)
				jQuery('#awd_fcbk_app_infos_metabox.postbox .inside').html(data);
				
			$(button).button('reset')
		});
	};
	
	this.showUploadDialog = function(button)
	{
		var $button = $(button);
		var $data = $button.data();
		var $field = $('#'+$data.field);
		var formfieldName =  $field.attr('name');
		tb_show($data.title, 'media-upload.php?type='+$data.type+'&amp;TB_iframe=true');
		window.send_to_editor = function(html){
			var imgurl = jQuery('img',html).attr('src');
			$field.val(imgurl);
			tb_remove();
		}
		return false;
	};
	
	this.bindEvents = function()
	{	
		var $awd = this;
		//Admin
		$(".alert").alert();
		$('#reload_app_infos').live('click',function(e){
			e.preventDefault();
			$awd.reloadAppInfos(this);
		});
		$('.awd_tooltip_donate').popover({
			placement: 'top',
			title : function(){
				return $(".header_lightbox_donate_title").html();
			},
			content: function(){
				var html = $("#lightbox_donate").html();
				if(html == null){html = '...';}
				return '<div class="AWD_facebook_wrap">'+html+'</div>';
			},
			delay:{
				show:300,
				hide:500
			}
		});
		
		$('.awd_tooltip').popover({
			placement: 'top',
			title : function(){
				return $(".header_lightbox_help_title").html();
			},
			content: function(){
				var id = $(this).attr('id');
				console.log(id);
				var html = $("#lightbox_"+id).html();
				if(html == null){html = '...';}
				return '<div class="AWD_facebook_wrap">'+html+'</div>';
			},
			delay:{
				show:300,
				hide:500
			}
		});
		
		$('#toogle_list_pages').live('click',function(e){
			e.preventDefault();
			$('.toogle_fb_pages').slideToggle();
		});
		$('#settings_menu a:first').tab('show');
		
		//Forms
		$(".AWD_button_media").click(function(e){
			e.preventDefault();
			$awd.showUploadDialog(this)
		});
		$('.awd_tooltip').click(function(e){ e.preventDefault();});
		$('#submit_settings').click(function(e){
			e.preventDefault();
			$('#awd_fcbk_option_form_settings').submit();
		});
		$('#reset_settings').click(function(e){
			e.preventDefault();  			
			$(".alert_reset_settings").slideDown();  
		});
		$('.reset_settings_dismiss').click(function(e){
			e.preventDefault();		
			$(".alert_reset_settings").slideUp();  
		});
		$('.reset_settings_confirm').click(function(e){
			e.preventDefault();   	
			$('#awd_fcbk_reset_settings').submit();
		});
		
		$('#awd_fcbk_option_connect_enable').change(function(){
			if($(this).val() == 1){
				$('.depend_fb_connect').attr('disabled', false);
			}else{
				$('.depend_fb_connect').attr('disabled', true);
			}
		});
		
		
		$('#awd_fcbk_option_like_button_type').change(function(){
			if($(this).val() == 'iframe'){
				$('#awd_fcbk_option_like_button_send').attr('disabled', true);
			}else{
				$('#awd_fcbk_option_like_button_send').attr('disabled', false);
			}
		});
		
		
		
		//FB events
		$('.get_permissions').live('click',function(e){
			e.preventDefault();
			var $this = $(this);
			var scope = $this.data('scope');
			FB.login(function(response)
			{
				if(response.authResponse) {
					console.log(response);
				    $('#awd_fcbk_form_settings').submit();
				}
			},{scope: scope});
		});
	};
	
	this.init = function()
	{
		$('.AWD_profile').wrap('<div class="well">');
		$('.AWD_logout a').addClass('btn btn-danger').css('marginTop','5px');
		$('.AWD_profile_image').addClass('pull-left').css('marginRight','10px');		
		$(".fadeOnload").delay(4000).fadeOut();		
		this.bindEvents();
	};
	this.init();
};
jQuery(document).ready( function($){
	var AWD_facebook_admin = new AWDFacebookAdmin($);
});

	
	