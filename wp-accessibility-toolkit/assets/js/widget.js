/**
 * Frontend Widget JavaScript for Accessibility Toolkit
 *
 * @package Accessibility_Toolkit
 */

(function($) {
    'use strict';

    /**
     * Accessibility Toolkit Widget Handler
     */
    const ATK_Widget = {

        /**
         * Initialize
         */
        init: function() {
            this.cacheDom();
            this.bindEvents();
            this.loadPreferences();
            this.applySettings();
        },

        /**
         * Cache DOM elements
         */
        cacheDom: function() {
            this.$toggle = $('#atk-toggle');
            this.$panel = $('#atk-panel');
            this.$close = $('#atk-close');
            this.$fontSizeBtns = $('.atk-font-size-btn');
            this.$dyslexiaToggle = $('#atk-dyslexia-toggle');
            this.$contrastToggle = $('#atk-contrast-toggle');
            this.$resetBtn = $('#atk-reset');
            this.$body = $('body');
        },

        /**
         * Bind events
         */
        bindEvents: function() {
            this.$toggle.on('click', this.togglePanel.bind(this));
            this.$close.on('click', this.closePanel.bind(this));
            this.$fontSizeBtns.on('click', this.setFontSize.bind(this));
            this.$dyslexiaToggle.on('click', this.toggleDyslexiaFont.bind(this));
            this.$contrastToggle.on('click', this.toggleHighContrast.bind(this));
            this.$resetBtn.on('click', this.resetSettings.bind(this));

            // Close panel on Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && this.$panel.is(':visible')) {
                    this.closePanel();
                }
            }.bind(this));

            // Close panel when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.atk-widget').length && this.$panel.is(':visible')) {
                    this.closePanel();
                }
            }.bind(this));
        },

        /**
         * Toggle panel visibility
         */
        togglePanel: function() {
            if (this.$panel.is(':visible')) {
                this.closePanel();
            } else {
                this.openPanel();
            }
        },

        /**
         * Open panel
         */
        openPanel: function() {
            this.$panel.slideDown(300);
            this.$toggle.attr('aria-expanded', 'true');
        },

        /**
         * Close panel
         */
        closePanel: function() {
            this.$panel.slideUp(300);
            this.$toggle.attr('aria-expanded', 'false');
        },

        /**
         * Set font size
         */
        setFontSize: function(e) {
            const size = $(e.currentTarget).data('size');

            // Remove all font size classes
            this.$body.removeClass('atk-font-small atk-font-medium atk-font-large');
            this.$fontSizeBtns.removeClass('active');

            // Add selected size class
            if (size) {
                this.$body.addClass('atk-font-' + size);
                $(e.currentTarget).addClass('active');

                // Apply custom font sizes from settings
                if (typeof atkSettings !== 'undefined') {
                    let fontSize;
                    switch(size) {
                        case 'small':
                            fontSize = atkSettings.fontSizeSmall;
                            break;
                        case 'medium':
                            fontSize = atkSettings.fontSizeMedium;
                            break;
                        case 'large':
                            fontSize = atkSettings.fontSizeLarge;
                            break;
                    }
                    if (fontSize) {
                        this.$body.css('font-size', fontSize + 'px');
                    }
                }

                // Save preference
                this.savePreference('fontSize', size);
            }
        },

        /**
         * Toggle dyslexia font
         */
        toggleDyslexiaFont: function() {
            const isActive = this.$body.hasClass('atk-dyslexia-font');

            if (isActive) {
                this.$body.removeClass('atk-dyslexia-font');
                this.$dyslexiaToggle.removeClass('active');
                this.$dyslexiaToggle.text(this.$dyslexiaToggle.text().replace('✓ ', ''));
                this.savePreference('dyslexiaFont', false);
            } else {
                this.$body.addClass('atk-dyslexia-font');
                this.$dyslexiaToggle.addClass('active');
                this.savePreference('dyslexiaFont', true);
            }
        },

        /**
         * Toggle high contrast
         */
        toggleHighContrast: function() {
            const isActive = this.$body.hasClass('atk-high-contrast');

            if (isActive) {
                this.$body.removeClass('atk-high-contrast');
                this.$contrastToggle.removeClass('active');
                this.$contrastToggle.text(this.$contrastToggle.text().replace('✓ ', ''));
                this.removeContrastStyles();
                this.savePreference('highContrast', false);
            } else {
                this.$body.addClass('atk-high-contrast');
                this.$contrastToggle.addClass('active');
                this.applyContrastStyles();
                this.savePreference('highContrast', true);
            }
        },

        /**
         * Apply contrast styles
         */
        applyContrastStyles: function() {
            if (typeof atkSettings !== 'undefined') {
                const style = document.createElement('style');
                style.id = 'atk-contrast-styles';
                style.textContent = `
                    body.atk-high-contrast {
                        background-color: ${atkSettings.backgroundColor} !important;
                        color: ${atkSettings.primaryColor} !important;
                    }
                    body.atk-high-contrast a {
                        color: ${atkSettings.linkColor} !important;
                    }
                `;
                document.head.appendChild(style);
            }
        },

        /**
         * Remove contrast styles
         */
        removeContrastStyles: function() {
            const style = document.getElementById('atk-contrast-styles');
            if (style) {
                style.remove();
            }
        },

        /**
         * Reset all settings
         */
        resetSettings: function() {
            // Remove all classes
            this.$body.removeClass('atk-font-small atk-font-medium atk-font-large atk-dyslexia-font atk-high-contrast');

            // Remove custom font size
            this.$body.css('font-size', '');

            // Reset buttons
            this.$fontSizeBtns.removeClass('active');
            this.$dyslexiaToggle.removeClass('active');
            this.$contrastToggle.removeClass('active');

            // Update button texts
            this.$dyslexiaToggle.text(this.$dyslexiaToggle.text().replace('✓ ', ''));
            this.$contrastToggle.text(this.$contrastToggle.text().replace('✓ ', ''));

            // Remove contrast styles
            this.removeContrastStyles();

            // Clear preferences
            this.clearPreferences();

            // Close panel
            this.closePanel();
        },

        /**
         * Apply settings from backend
         */
        applySettings: function() {
            if (typeof atkSettings !== 'undefined') {
                // Set CSS variables for font sizes
                document.documentElement.style.setProperty('--atk-font-size-small', atkSettings.fontSizeSmall + 'px');
                document.documentElement.style.setProperty('--atk-font-size-medium', atkSettings.fontSizeMedium + 'px');
                document.documentElement.style.setProperty('--atk-font-size-large', atkSettings.fontSizeLarge + 'px');

                // Set CSS variables for colors
                document.documentElement.style.setProperty('--atk-text-color', atkSettings.primaryColor);
                document.documentElement.style.setProperty('--atk-bg-color', atkSettings.backgroundColor);
                document.documentElement.style.setProperty('--atk-link-color', atkSettings.linkColor);
            }
        },

        /**
         * Save preference to localStorage
         */
        savePreference: function(key, value) {
            try {
                const prefs = this.getPreferences();
                prefs[key] = value;
                localStorage.setItem('atk_preferences', JSON.stringify(prefs));
            } catch (e) {
                console.warn('ATK: Could not save preference', e);
            }
        },

        /**
         * Get preferences from localStorage
         */
        getPreferences: function() {
            try {
                const prefs = localStorage.getItem('atk_preferences');
                return prefs ? JSON.parse(prefs) : {};
            } catch (e) {
                console.warn('ATK: Could not load preferences', e);
                return {};
            }
        },

        /**
         * Load preferences and apply them
         */
        loadPreferences: function() {
            const prefs = this.getPreferences();

            // Apply font size
            if (prefs.fontSize) {
                const $btn = this.$fontSizeBtns.filter('[data-size="' + prefs.fontSize + '"]');
                if ($btn.length) {
                    $btn.trigger('click');
                }
            }

            // Apply dyslexia font
            if (prefs.dyslexiaFont) {
                this.$dyslexiaToggle.trigger('click');
            }

            // Apply high contrast
            if (prefs.highContrast) {
                this.$contrastToggle.trigger('click');
            }
        },

        /**
         * Clear all preferences
         */
        clearPreferences: function() {
            try {
                localStorage.removeItem('atk_preferences');
            } catch (e) {
                console.warn('ATK: Could not clear preferences', e);
            }
        }
    };

    /**
     * Initialize on DOM ready
     */
    $(document).ready(function() {
        if ($('#atk-widget').length) {
            ATK_Widget.init();
        }
    });

})(jQuery);
