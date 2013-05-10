/**
 *
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 *
 */
var AWD_facebook = function() {

    return {
        
        /**
         *
         * @returns {undefined}
         */
        FbEventHandler: function()
        {
            if (awd_fcbk.FBEventHandler.callbacks) {
                jQuery.each(awd_fcbk.FBEventHandler.callbacks, function(index, value) {
                    var AWD_actions_callback = window[this];
                    if (jQuery.isFunction(AWD_actions_callback))
                        AWD_actions_callback(this);
                });
            }

            jQuery('.AWD_facebook_connect_button').live('click', function(e) {
                e.preventDefault();
                var redirect_url = jQuery(this).data('redirect');
                AWD_facebook.connect(redirect_url);
            });
        },

        /**
         *
         * @param {type} response
         * @param {type} redirect_url
         * @returns {undefined}
         */
        callbackLogin: function(response, redirect_url)
        {
            var redirect = '';
            if (response.authResponse) {
                if (!redirect_url) {
                    window.location.href = awd_fcbk.loginUrl;
                } else {
                    var sep = (awd_fcbk.loginUrl.indexOf('?') > -1) ? '&' : '?';
                    window.location.href = awd_fcbk.loginUrl + sep + "redirect_to=" + redirect_url;
                }
            }
        },

        /**
         *
         * @param {type} redirect_url
         * @returns {Boolean}
         */
        connect: function(redirect_url)
        {
            FB.login(
                    function(response) {
                        AWD_facebook.fbConnected = true;
                        AWD_facebook.callbackLogin(response, redirect_url);
                    },
                    {
                        scope: awd_fcbk.scope
                    }
            );
            return false;
        },

        /**
         *
         * @returns {undefined}
         */
        logout: function() {
            window.location.href = awd_fcbk.logoutUrl;
        },

        /**
         *
         * @returns {@exp;AWD_facebook@pro;fbConnected}
         */
        isFbConnected: function() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    AWD_facebook.fbConnected = true;
                    AWD_facebook.access_token = response.authResponse.accessToken;
                }
            });
            return AWD_facebook.fbConnected;
        }
    };
}();
