/*
 * 
 * 
 */
var FacebookAwdAdmin = function() {
    var $ = jQuery;

    this.bindEvents = function() {

        /**
         * Hide event on change value.
         * true = show
         * false = hidden
         */
        $(document).on('change', '.hideIfOn', function(e) {
            var sectionsHideOn = $(this).data('hideOn');
            var value = $(e.target).val() === '1' ? true : false;
            var $section = $(e.target).parents('.posttype_section').find(sectionsHideOn);
            if (value) {
                $section.show();
                return;
            }
            return $section.hide();
        });
        $('.hideIfOn').trigger('change');
    };
};
