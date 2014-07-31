/*
 * Facebook AWD helpers
 */
var FacebookAWD = function() {
};

var facebookAWD = new FacebookAWD();

jQuery(document).ready(function($) {
    $(window).trigger('FacebookAWD_ready', facebookAWD);
});

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));