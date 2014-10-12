/*
 * Facebook AWD Admin helpers
 * 
 * Init
 */
var facebookAWDAdmin = new FacebookAWDAdmin();

/**
 * Init
 */
jQuery(document).ready(function($) {
    facebookAWDAdmin.bindEvents();
    $(window).trigger('FacebookAWDAdmin_ready', facebookAWDAdmin);
});

/**
 * Load async of the facebook sdk
 */
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/fr_FR/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
