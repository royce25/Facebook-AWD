/**
 * Init
 */

facebookAwdAdmin = new FacebookAwdAdmin();
jQuery(document).ready(function($) {
    facebookAwdAdmin.bindEvents();
    $(window).trigger('facebookAwdAdmin_ready', facebookAwdAdmin);
});

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=409317535749344&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));