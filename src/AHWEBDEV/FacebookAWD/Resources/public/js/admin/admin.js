/*
 * Facebook AWD Admin helpers
 */
var FacebookAWDAdmin = function () {
    var $ = jQuery;
    var admin = this;
    /**
     * Bind the events
     * s
     * @returns {void}
     */
    this.bindEvents = function () {

        /**
         * Hide event on change value.
         * true = show
         * false = hidden
         */
        $(document).on('change', '.hideIfOn', function (e, data) {
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

    /**
     * Animate the metabox admin
     * 
     * @returns {void}
     */
    this.animateAdmin = function () {
        $btns = $('#postbox-container-2 a.btn');
        $btns.on('click', function (e) {
            e.preventDefault();
            $(this).removeClass('fadeIn').addClass('fadeOutLeft');

            if ($(this).attr('href').indexOf('#') !== 0) {
                window.location.href = $(this).attr('href');
            }
        });
        //$btns.addClass('animated fadeIn').show();
    };

    /**
     * Submit settings form
     * @param {Object} $form
     * @returns {void}
     */
    this.submitSettingsForm = function ($form, action) {
        var data = $form.serialize() + '&action=' + action;
        $.post(ajaxurl, data, function (data) {
            admin.insertSection(data);
        }, 'json');
    };

    /**
     * Insert a section in admin
     * @param {Object} data
     * @returns {void}
     */
    this.insertSection = function (data) {
        //insert new section
        $('.section.' + data.sectionClass).replaceWith(data.section);

        var $newSection = $('.section.' + data.sectionClass);
        $('.hideIfOn').trigger('change', {direct: 1});

        //re parse xfbml if needed
        FB.XFBML.parse($newSection.get(0));

        //scroll to the top of the section
        $('html, body').animate({
            scrollTop: $newSection.offset().top - 40
        });


        //hide alert after 5 secondes
        var $alert = $newSection.find('.alert-success');
        $alert.addClass('animated fadeInDown');
        clearTimeout(t1);
        var t1 = setTimeout(function () {
            $alert.removeClass('fadeInDown').addClass('fadeOutUp');
            clearTimeout(t2);
            var t2 = setTimeout(function () {
                $alert.slideUp();
            }, 500);
        }, 5000);
    };
};
