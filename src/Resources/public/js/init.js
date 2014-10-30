/*
 * Facebook AWD helpers
 */
var FacebookAWD = function (options) {
    var me = this;
    var $ = jQuery;
    this.bindEvents = function () {
        window.fbAsyncInit = function () {
            var defaults = {
                appId: facebookawdData.appId,
                xfbml: true,
                status: true,
                version: 'v2.0',
                cookie: true
            };
            var options = $.extend(defaults, options);
            FB.init(options);
            $(window).trigger('FacebookAWD_ready', me);
        };
    };
};

var facebookAWD = new FacebookAWD();

jQuery(document).ready(function ($) {
    facebookAWD.bindEvents();
});

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));