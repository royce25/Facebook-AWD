/*
*
* JS AWD FCBK
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
jQuery(document).ready(function($){
	$('.AWD_facebook_custom_action').each(function(index,parent){
		var $this = $(this);
		var data = $this.data();
		//create eventlistener on the element
		$this.bind(data.typeEvent,function(e){
			e.preventDefault();
			$.post(awd_fcbk.ajaxurl,
			{
				action				: 'call_action_open_graph',
				awd_action			: data.action,
				awd_object			: data.object,
				awd_url				: data.url,
				awd_responsetext 	: data.responsetext,
				awd_callbackjs		: data.callbackjs
			},
			function(ajax_data){
				if(ajax_data.callbackJs){
					var AWD_action_callback = window[ajax_data.callbackJs];
					AWD_action_callback(this,ajax_data);
				}else if(ajax_data.success){
					if(data.typeEvent != 'AWD_facebook_tracker'){
						$this.removeClass('.AWD_error_highlight').addClass('.AWD_success');
					if(ajax_data.htmlResponse)
						$this.html(ajax_data.htmlResponse);
					}

					if(data.typeEvent != 'AWD_facebook_tracker'){
						$this.removeClass('.AWD_success').addClass('.AWD_error_highlight');
						if(ajax_data.htmlResponse)
							$this.append(ajax_data.message);
					}
				}
			},"json");
		});

		if(data.typeEvent == 'AWD_facebook_tracker')
			//launch by tracker if needed.
			$this.trigger('AWD_facebook_tracker');
	});
});


var AWD_facebook = {

	FBEventHandler : function ()
	{
		//none for the moment
	},
	
	redirectToLogin : function(redirect_url)
	{
		if(response.authResponse) window.location.href = awd_fcbk.loginUrl;
	},
	
	connect :function(redirect_url)
	{
		FB.login(
			AWD_facebook.redirectToLogin,
			{ scope: awd_fcbk.scope }
		);
		return false;
	},
	
	isFbConnected : function(){
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				return true;
			}
			return false;
		});
	}
}