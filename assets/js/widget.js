/**
 * WP Accessibility Widget JavaScript
 * Handles font size controls, dragging, and settings persistence
 */

(function($) {
    'use strict';

    // Default settings
    const DEFAULT_FONT_SIZE = 'medium';
    const FONT_SIZES = ['small', 'medium', 'large', 'xlarge', 'xxlarge'];

    let currentFontSizeIndex = 1; // Default to 'medium' (index 1)
    let isDragging = false;
    let dragOffset = { x: 0, y: 0 };

    $(document).ready(function() {
        initWidget();
    });

    /**
     * Initialize widget functionality
     */
    function initWidget() {
        loadSettings();
        bindEvents();
        updateFontSizeDisplay();
    }

    /**
     * Bind event handlers
     */
    function bindEvents() {
        const $widget = $('#wp-accessibility-widget');
        const $header = $widget.find('.widget-header');
        const $toggle = $widget.find('.widget-toggle');

        // Toggle widget collapse/expand
        $toggle.on('click', function(e) {
            e.stopPropagation();
            $widget.toggleClass('collapsed');
            saveSettings();
        });

        // Dragging functionality
        $header.on('mousedown', startDrag);
        $(document).on('mousemove', drag);
        $(document).on('mouseup', stopDrag);

        // Font size controls
        $('#increase-font').on('click', increaseFontSize);
        $('#decrease-font').on('click', decreaseFontSize);
        $('#reset-font').on('click', resetFontSize); // Fixed: Proper reset functionality

        // Dyslexic font toggle
        $('#toggle-dyslexic-font').on('change', toggleDyslexicFont);

        // Reset all settings
        $('#reset-all').on('click', resetAllSettings);
    }

    /**
     * Start dragging the widget
     */
    function startDrag(e) {
        if ($(e.target).closest('.widget-toggle').length) {
            return;
        }

        isDragging = true;
        const $widget = $('#wp-accessibility-widget');
        $widget.addClass('dragging');

        const offset = $widget.offset();
        dragOffset.x = e.pageX - offset.left;
        dragOffset.y = e.pageY - offset.top;

        e.preventDefault();
    }

    /**
     * Handle dragging movement
     */
    function drag(e) {
        if (!isDragging) return;

        const $widget = $('#wp-accessibility-widget');
        const newLeft = e.pageX - dragOffset.x;
        const newTop = e.pageY - dragOffset.y;

        // Keep widget within viewport bounds
        const maxLeft = $(window).width() - $widget.outerWidth();
        const maxTop = $(window).height() - $widget.outerHeight();

        const boundedLeft = Math.max(0, Math.min(newLeft, maxLeft));
        const boundedTop = Math.max(0, Math.min(newTop, maxTop));

        $widget.css({
            left: boundedLeft + 'px',
            top: boundedTop + 'px'
        });

        e.preventDefault();
    }

    /**
     * Stop dragging the widget
     */
    function stopDrag() {
        if (!isDragging) return;

        isDragging = false;
        $('#wp-accessibility-widget').removeClass('dragging');
        saveSettings();
    }

    /**
     * Increase font size
     * Fixed: Prevents going beyond maximum size
     */
    function increaseFontSize() {
        if (currentFontSizeIndex < FONT_SIZES.length - 1) {
            currentFontSizeIndex++;
            applyFontSize();
            saveSettings();
        }
    }

    /**
     * Decrease font size
     * Fixed: Prevents going below minimum size
     */
    function decreaseFontSize() {
        if (currentFontSizeIndex > 0) {
            currentFontSizeIndex--;
            applyFontSize();
            saveSettings();
        }
    }

    /**
     * Reset font size to default
     * Fixed: Now properly resets to default 'medium' size
     */
    function resetFontSize() {
        currentFontSizeIndex = 1; // Reset to 'medium'
        applyFontSize();
        saveSettings();

        // Visual feedback
        const $resetBtn = $('#reset-font');
        $resetBtn.text('✓');
        setTimeout(function() {
            $resetBtn.text('A');
        }, 500);
    }

    /**
     * Apply the current font size to body
     * Fixed: Properly removes old classes and applies new one
     */
    function applyFontSize() {
        const $body = $('body');

        // Remove all font size classes
        FONT_SIZES.forEach(function(size) {
            $body.removeClass('font-size-' + size);
        });

        // Apply current font size class
        const currentSize = FONT_SIZES[currentFontSizeIndex];
        $body.addClass('font-size-' + currentSize);

        updateFontSizeDisplay();
    }

    /**
     * Update visual feedback for font size buttons
     */
    function updateFontSizeDisplay() {
        const $increaseBtn = $('#increase-font');
        const $decreaseBtn = $('#decrease-font');

        // Disable/enable buttons based on current size
        if (currentFontSizeIndex >= FONT_SIZES.length - 1) {
            $increaseBtn.css('opacity', '0.5').prop('disabled', true);
        } else {
            $increaseBtn.css('opacity', '1').prop('disabled', false);
        }

        if (currentFontSizeIndex <= 0) {
            $decreaseBtn.css('opacity', '0.5').prop('disabled', true);
        } else {
            $decreaseBtn.css('opacity', '1').prop('disabled', false);
        }
    }

    /**
     * Toggle dyslexic-friendly font
     */
    function toggleDyslexicFont() {
        const isChecked = $(this).is(':checked');

        if (isChecked) {
            $('body').addClass('dyslexic-font');
        } else {
            $('body').removeClass('dyslexic-font');
        }

        saveSettings();
    }

    /**
     * Reset all accessibility settings
     * Fixed: Complete reset of all settings to defaults
     */
    function resetAllSettings() {
        // Confirm with user
        if (!confirm('Biztosan visszaállítja az összes beállítást?')) {
            return;
        }

        // Reset font size to default
        currentFontSizeIndex = 1; // medium
        applyFontSize();

        // Disable dyslexic font
        $('body').removeClass('dyslexic-font');
        $('#toggle-dyslexic-font').prop('checked', false);

        // Reset widget position
        $('#wp-accessibility-widget').css({
            top: '10%',
            left: '10%'
        });

        // Expand widget if collapsed
        $('#wp-accessibility-widget').removeClass('collapsed');

        // Clear localStorage
        localStorage.removeItem('wpAccessibilitySettings');

        // Visual feedback
        const $resetBtn = $('#reset-all');
        const originalText = $resetBtn.text();
        $resetBtn.text('✓ Visszaállítva!');
        setTimeout(function() {
            $resetBtn.text(originalText);
        }, 2000);
    }

    /**
     * Save settings to localStorage
     */
    function saveSettings() {
        const $widget = $('#wp-accessibility-widget');
        const position = $widget.position();

        const settings = {
            fontSizeIndex: currentFontSizeIndex,
            dyslexicFont: $('#toggle-dyslexic-font').is(':checked'),
            collapsed: $widget.hasClass('collapsed'),
            position: {
                top: position.top,
                left: position.left
            }
        };

        localStorage.setItem('wpAccessibilitySettings', JSON.stringify(settings));
    }

    /**
     * Load settings from localStorage
     */
    function loadSettings() {
        const savedSettings = localStorage.getItem('wpAccessibilitySettings');

        if (!savedSettings) {
            // Apply default settings
            applyFontSize();
            return;
        }

        try {
            const settings = JSON.parse(savedSettings);

            // Restore font size
            if (typeof settings.fontSizeIndex !== 'undefined') {
                currentFontSizeIndex = settings.fontSizeIndex;
                applyFontSize();
            }

            // Restore dyslexic font
            if (settings.dyslexicFont) {
                $('body').addClass('dyslexic-font');
                $('#toggle-dyslexic-font').prop('checked', true);
            }

            // Restore collapsed state
            if (settings.collapsed) {
                $('#wp-accessibility-widget').addClass('collapsed');
            }

            // Restore position
            if (settings.position) {
                $('#wp-accessibility-widget').css({
                    top: settings.position.top + 'px',
                    left: settings.position.left + 'px'
                });
            }
        } catch (e) {
            console.error('Error loading accessibility settings:', e);
            applyFontSize();
        }
    }

})(jQuery);
