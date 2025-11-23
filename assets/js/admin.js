/**
 * Admin JavaScript for Accessibility Toolkit
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize color pickers
        $('.atk-color-picker').wpColorPicker();

        // Handle position field visibility
        function updatePositionFields() {
            var selectedPosition = $('#widget_position').val();

            $('.atk-position-field').removeClass('active');

            $('.atk-position-field').each(function() {
                var allowedPositions = $(this).data('positions').split(',');
                if (allowedPositions.indexOf(selectedPosition) !== -1) {
                    $(this).addClass('active');
                }
            });
        }

        // Initial update
        updatePositionFields();

        // Update on change
        $('#widget_position').on('change', updatePositionFields);
    });

})(jQuery);
