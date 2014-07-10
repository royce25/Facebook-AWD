/*
 * 
 * 
 */
FacebookAwdAdmin.prototype.likeButton = {
    bindLikeButtonForm: function() {
        var $ = jQuery;
        var facebookAwdAdmin = this;
        $(' .posttype_section form').ajaxForm({
            dataType: 'JSON',
            url: ajaxurl,
            beforeSubmit: function(formData) {
                console.log(formData);
                formData.push({name: 'action', value: 'save_likebutton_settings'});
            },
            success: function(data) {

                $('.posttype_section.' + data.postTypeName).replaceWith(data.section);
                var $newSection = $('.posttype_section.' + data.postTypeName);
                $('html, body').animate({
                    scrollTop: $newSection.offset().top - 40
                });
                facebookAwdAdmin.bindLikeButtonForm();
            }
        });
    }
};

/**
 * Init
 */
jQuery(document).ready(function($) {
    $(document).on('facebook_awd_ready', function() {
        
    });
});

