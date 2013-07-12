/**
 *
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 *
 */
function AWDFacebookAdmin() {
    var $ = jQuery;
    /**
     *
     * @returns {undefined}
     */
    this.bindEvents = function()
    {

    };

    this.setHistory = function(object, title, url)
    {
        if (history.pushState) { // check if the browser supports the pushState
            history.pushState(object, title, url);
        }
    };

    /**
     *
     * @returns {undefined}
     */
    this.initTab = function()
    {
        var $this = this;
        //Tab system.
        $('#myTab a[href="' + window.location.hash + '"]').tab('show');
        $this.setHistory({type: 'facebookAWD'}, "", window.location.href);
        $('#myTab a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
            $this.setHistory({type: 'facebookAWD'}, "", $(this).attr('href'));
        });

        //History state.
        $(window).bind("popstate", function(evt) {
            var state = evt.originalEvent.state;
            if (state && state.type === "facebookAWD") {
                $('#myTab a[href="' + window.location.hash + '"]').tab('show');
            }
        });
    };

    /**
     *
     * @returns {undefined}
     */
    this.init = function()
    {
        this.bindEvents();
        this.initTab();
        //$('.AWD_facebook').button();
    };

    this.init();
}
(jQuery);

var AWD_facebook_admin;
jQuery(function() {
    AWD_facebook_admin = new AWDFacebookAdmin();
});


