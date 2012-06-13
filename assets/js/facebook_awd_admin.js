/*
*
* JS AWD FCBK
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
var AWD_facebook_admin = {
	
	init: function()
	{
		//Css class for login button design.
		$('.AWD_profile').wrap('<div class="well">');
		$('.AWD_logout a').addClass('btn btn-danger').css('marginTop','5px');
		$('.AWD_profile_image').addClass('pull-left').css('marginRight','10px');
		
		//hide fadelement
		$(".fadeOnload").delay(4000).fadeOut();
		
		AWD_facebook_admin.bindEvents();
	},
	
	bindEvents : function()
	{	
		//Reload app content from opg api
		$('#reload_app_infos').live('click',function(e){
			e.preventDefault();
			AWD_facebook_admin.reloadAppInfos(this);
		});
	},
	
	reloadAppInfos : function(button)
	{
		$(button).html('<img src="/wp-content/plugins/facebook-awd/assets/css/images/loading.gif" alt="loading..."/>');
		$.post(ajaxurl,{action:'get_app_infos_content'},function(data){	
			if(data)
				jQuery('#awd_fcbk_app_infos_metabox.postbox .inside').html(data);
		});
	},
	
	showUploadDialog : function(button)
	{
		
	},
	
	//button upload
	$(".AWD_button_media").click(function(){
		var $button = $(this);
		var $data = $(this).data();
		var $field = $('#'+$data.field);
		var formfieldName =  $field.attr('name');
		tb_show($data.title, 'media-upload.php?type='+$data.type+'&amp;TB_iframe=true');
		window.send_to_editor = function(html) {
			var imgurl = jQuery('img',html).attr('src');
			$field.val(imgurl);
			tb_remove();
		}
		return false;
	});
	
};


//Jquery Init
jQuery(document).ready( function($){

	
	
	//accordion brefore opg
	var icons = {
		header: "ui-icon-circle-arrow-e",
		headerSelected: "ui-icon-circle-arrow-s"
	};
	$("[id^='ogtags_']:not(div#ogtags_taxonomies > div.ui_ogtags_form)").accordion({
		header: "h4",
		autoHeight: false,
		icons:icons,
		collapsible: true,
		active: false
	});
	//Accordion opg
	$(".ui_ogtags_form").accordion({
		header: "h4",
		autoHeight: false,
		icons:{
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		},
		collapsible: true,
		active: false
	});
	//For custom og type selector in opg form
	$('.facebook_AWD_select_ogtype').each(function(){
		update_custom_type($(this));
		$(this).change(function(){
			update_custom_type($(this));
		});
	});
	//Tag in opg
	var id_focused="";
	$(":input").focus(function () {
		id_focused = this.id;
	});
	$(".awd_pre b").click(function(){	
		var b = jQuery(this);
		var value = jQuery("#"+id_focused).val();
		$("#"+id_focused).val(value + b.html());
	});
	
	//tooltip in admin
	$('.awd_tooltip').popover({
		title : function(){
			return $(".header_lightbox_help_title").html();
		},
		content: function(){
			var id = $(this).attr('id');
			var html = $("#lightbox_"+id).html();
			if(html == null){html = '...';}
			return '<div class="AWD_facebook_wrap">'+html+'</div>';
		},
		delay:{
			show:300,
			hide:500
		}
	});
	$('.awd_tooltip').click(function(e){
		e.preventDefault();
	});
	
	//tooltip in admin
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
});
//Hide or show state
function hide_state(elem,elem_to_hide){
	if(jQuery(elem).attr('checked') != "checked"){
		jQuery(elem_to_hide).fadeOut();
	}else{
		jQuery(elem_to_hide).show();
	}
}
function update_custom_type($element){
	if($element.val() == 'custom'){
		jQuery("#"+$element.attr('id')+"_custom").slideDown();
		jQuery("#"+$element.attr('id')+"_custom").attr('disabled',false);
	}else{
		jQuery("#"+$element.attr('id')+"_custom").slideUp();
		jQuery("#"+$element.attr('id')+"_custom").attr('disabled',true);
	}
}
	
	