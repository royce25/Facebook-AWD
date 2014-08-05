/*
 * Facebook AWD Admin helpers
 */
var FacebookAWDAdmin = function() {
    var $ = jQuery;

    this.bindEvents = function() {

        /**
         * Hide event on change value.
         * true = show
         * false = hidden
         */
        $(document).on('change', '.hideIfOn', function(e, data) {
            var sectionsHideOn = $(this).data('hideOn');
            var value = $(e.target).val() === '1' ? true : false;
            var $section = $(e.target).parents('.section').find(sectionsHideOn);
            data = data || {};
            if (!data.direct) {
                if (value) {
                    return $section.slideDown();
                } else {
                    return $section.slideUp();
                }
            } else {
                if (value) {
                    return $section.show();
                } else {
                    return $section.hide();
                }
            }

        });
        $('.hideIfOn').trigger('change', {direct: 1});

        this.animateAdmin();
    };

    this.animateAdmin = function() {
        $btns = $('#postbox-container-2 a.btn');
        $btns.on('click', function(e) {
            e.preventDefault();
            $(this).removeClass('fadeIn').addClass('fadeOutLeft');

            if ($(this).attr('href').indexOf('#') !== 0) {
                window.location.href = $(this).attr('href');
            }
        });
        //$btns.addClass('animated fadeIn').show();
    };
};
