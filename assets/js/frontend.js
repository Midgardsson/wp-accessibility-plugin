/**
 * Frontend JavaScript for Accessibility Toolkit
 */

(function($) {
    'use strict';

    // Configuration
    const ATK = {
        // State
        state: {
            fontSize: 100,
            dyslexiaFont: false,
            darkMode: false,
            highContrast: false,
            panelOpen: false
        },

        // Settings from backend
        settings: window.atkSettings || {},

        // Constants
        constants: {
            MIN_FONT_SIZE: 80,
            MAX_FONT_SIZE: 200,
            FONT_STEP: 10,
            STORAGE_KEY: 'atk_user_preferences',
            COOKIE_NAME: 'atk_user_settings'
        },

        /**
         * Initialize the toolkit
         */
        init: function() {
            this.applyWidgetPosition();
            this.loadUserPreferences();
            this.bindEvents();
            this.applyStoredSettings();
            this.updateDisplay();
        },

        /**
         * Apply widget position from backend settings
         */
        applyWidgetPosition: function() {
            const widget = $('#atk-widget');
            const position = this.settings.widgetPosition || 'floating';

            // Apply positioning styles
            const positionStyles = {
                top: this.settings.positionTop || 'auto',
                bottom: this.settings.positionBottom || 'auto',
                left: this.settings.positionLeft || 'auto',
                right: this.settings.positionRight || 'auto'
            };

            // Clean up auto values
            Object.keys(positionStyles).forEach(function(key) {
                if (positionStyles[key] === 'auto') {
                    positionStyles[key] = '';
                }
            });

            // Apply position based on mode
            switch(position) {
                case 'edge-left':
                    widget.css({
                        top: positionStyles.top || '20px',
                        left: '0',
                        right: '',
                        bottom: ''
                    });
                    break;

                case 'edge-right':
                    widget.css({
                        top: positionStyles.top || '20px',
                        right: '0',
                        left: '',
                        bottom: ''
                    });
                    break;

                case 'edge-bottom':
                    widget.css({
                        bottom: '0',
                        right: positionStyles.right || '20px',
                        top: '',
                        left: ''
                    });
                    break;

                case 'floating':
                default:
                    widget.css({
                        top: positionStyles.top || '20px',
                        right: positionStyles.right || '20px',
                        bottom: '',
                        left: ''
                    });
                    break;
            }
        },

        /**
         * Bind event handlers
         */
        bindEvents: function() {
            const self = this;

            // Toggle widget panel
            $('.atk-toggle-button').on('click', function(e) {
                e.preventDefault();
                self.togglePanel();
            });

            // Close panel
            $('.atk-close-button').on('click', function(e) {
                e.preventDefault();
                self.closePanel();
            });

            // Close panel on escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && self.state.panelOpen) {
                    self.closePanel();
                }
            });

            // Close panel when clicking outside
            $(document).on('click', function(e) {
                if (self.state.panelOpen &&
                    !$(e.target).closest('#atk-widget').length) {
                    self.closePanel();
                }
            });

            // Font size controls
            $('[data-action="increase-font"]').on('click', function(e) {
                e.preventDefault();
                self.increaseFontSize();
            });

            $('[data-action="decrease-font"]').on('click', function(e) {
                e.preventDefault();
                self.decreaseFontSize();
            });

            $('[data-action="reset-font"]').on('click', function(e) {
                e.preventDefault();
                self.resetFontSize();
            });

            // Dyslexia font toggle
            $('[data-action="toggle-dyslexia"]').on('change', function() {
                self.toggleDyslexiaFont($(this).is(':checked'));
            });

            // Dark mode toggle
            $('[data-action="toggle-dark-mode"]').on('change', function() {
                self.toggleDarkMode($(this).is(':checked'));
            });

            // High contrast toggle
            $('[data-action="toggle-high-contrast"]').on('change', function() {
                self.toggleHighContrast($(this).is(':checked'));
            });

            // Reset all
            $('[data-action="reset-all"]').on('click', function(e) {
                e.preventDefault();
                self.resetAll();
            });
        },

        /**
         * Toggle panel visibility
         */
        togglePanel: function() {
            if (this.state.panelOpen) {
                this.closePanel();
            } else {
                this.openPanel();
            }
        },

        /**
         * Open panel
         */
        openPanel: function() {
            const panel = $('#atk-panel');
            const toggleButton = $('.atk-toggle-button');

            panel.attr('aria-hidden', 'false');
            toggleButton.attr('aria-expanded', 'true');
            this.state.panelOpen = true;

            // Focus first interactive element
            setTimeout(function() {
                panel.find('button, input, select, textarea').first().focus();
            }, 300);
        },

        /**
         * Close panel
         */
        closePanel: function() {
            const panel = $('#atk-panel');
            const toggleButton = $('.atk-toggle-button');

            panel.attr('aria-hidden', 'true');
            toggleButton.attr('aria-expanded', 'false');
            this.state.panelOpen = false;

            // Return focus to toggle button
            toggleButton.focus();
        },

        /**
         * Increase font size
         */
        increaseFontSize: function() {
            const maxSize = Math.min(
                this.constants.MAX_FONT_SIZE,
                parseInt(this.settings.maxFontSize) || 60
            );

            // Calculate max percentage based on max px (60px is 200% at most)
            const maxPercentage = Math.min(200, (maxSize / 16) * 100);

            if (this.state.fontSize < maxPercentage) {
                this.state.fontSize = Math.min(
                    this.state.fontSize + this.constants.FONT_STEP,
                    maxPercentage
                );
                this.applyFontSize();
                this.updateDisplay();
                this.saveUserPreferences();
            }
        },

        /**
         * Decrease font size
         */
        decreaseFontSize: function() {
            if (this.state.fontSize > this.constants.MIN_FONT_SIZE) {
                this.state.fontSize = Math.max(
                    this.state.fontSize - this.constants.FONT_STEP,
                    this.constants.MIN_FONT_SIZE
                );
                this.applyFontSize();
                this.updateDisplay();
                this.saveUserPreferences();
            }
        },

        /**
         * Reset font size
         */
        resetFontSize: function() {
            this.state.fontSize = 100;
            this.applyFontSize();
            this.updateDisplay();
            this.saveUserPreferences();
        },

        /**
         * Apply font size to body
         */
        applyFontSize: function() {
            const maxSize = Math.min(
                parseInt(this.settings.maxFontSize) || 60,
                60 // Absolute maximum
            );

            // Calculate actual font size in pixels
            const baseFontSize = 16; // Default browser base size
            const targetSize = (this.state.fontSize / 100) * baseFontSize;
            const actualSize = Math.min(targetSize, maxSize);

            $('body').addClass('atk-font-adjusted');

            // Apply to body and all children
            $('body').css('font-size', actualSize + 'px');

            // Apply to all text elements with proper scaling
            $('body *').not('.atk-widget, .atk-widget *').each(function() {
                const element = $(this);
                const computedSize = parseFloat(window.getComputedStyle(this).fontSize);

                // Calculate new size maintaining relative proportions
                const scaleFactor = actualSize / baseFontSize;
                let newSize = computedSize * (scaleFactor / (parseInt(element.attr('data-atk-scale')) || 1));

                // Apply maximum limit
                newSize = Math.min(newSize, maxSize);

                element.css('font-size', newSize + 'px');
                element.attr('data-atk-scale', scaleFactor);
            });
        },

        /**
         * Toggle dyslexia-friendly font
         */
        toggleDyslexiaFont: function(enabled) {
            this.state.dyslexiaFont = enabled;

            if (enabled) {
                // Force apply dyslexia font with maximum specificity
                $('body').addClass('atk-dyslexia-font');

                // Force font on all elements
                setTimeout(function() {
                    $('body, body *').not('.atk-widget, .atk-widget *').each(function() {
                        $(this).css({
                            'font-family': 'OpenDyslexic, "Comic Sans MS", sans-serif',
                            'font-family': 'OpenDyslexic, "Comic Sans MS", sans-serif !important'
                        });
                    });
                }, 100);
            } else {
                $('body').removeClass('atk-dyslexia-font');

                // Remove inline font-family styles
                $('body, body *').not('.atk-widget, .atk-widget *').each(function() {
                    const style = $(this).attr('style');
                    if (style && style.includes('font-family')) {
                        $(this).css('font-family', '');
                    }
                });
            }

            this.updateDisplay();
            this.saveUserPreferences();
        },

        /**
         * Toggle dark mode
         */
        toggleDarkMode: function(enabled) {
            // Disable high contrast if enabling dark mode
            if (enabled && this.state.highContrast) {
                this.toggleHighContrast(false);
                $('#atk-high-contrast').prop('checked', false);
            }

            this.state.darkMode = enabled;

            if (enabled) {
                // Set CSS custom properties from settings
                const bgColor = this.settings.darkBgColor || '#121212';
                const textColor = this.settings.darkTextColor || '#ffffff';
                const opacity = parseFloat(this.settings.darkBgOpacity) || 0.95;

                document.documentElement.style.setProperty('--atk-dark-bg', bgColor);
                document.documentElement.style.setProperty('--atk-dark-text', textColor);
                document.documentElement.style.setProperty('--atk-dark-opacity', opacity);

                $('body').addClass('atk-dark-mode');
            } else {
                $('body').removeClass('atk-dark-mode');
            }

            this.updateDisplay();
            this.saveUserPreferences();
        },

        /**
         * Toggle high contrast mode
         */
        toggleHighContrast: function(enabled) {
            // Disable dark mode if enabling high contrast
            if (enabled && this.state.darkMode) {
                this.toggleDarkMode(false);
                $('#atk-dark-mode').prop('checked', false);
            }

            this.state.highContrast = enabled;

            if (enabled) {
                // Set CSS custom properties from settings
                const bgColor = this.settings.highContrastBg || '#000000';
                const textColor = this.settings.highContrastText || '#ffff00';

                document.documentElement.style.setProperty('--atk-contrast-bg', bgColor);
                document.documentElement.style.setProperty('--atk-contrast-text', textColor);

                $('body').addClass('atk-high-contrast');

                // Fix widget position to prevent jumping
                this.applyWidgetPosition();
            } else {
                $('body').removeClass('atk-high-contrast');
            }

            this.updateDisplay();
            this.saveUserPreferences();
        },

        /**
         * Reset all settings
         */
        resetAll: function() {
            // Reset state
            this.state.fontSize = 100;
            this.state.dyslexiaFont = false;
            this.state.darkMode = false;
            this.state.highContrast = false;

            // Remove all classes
            $('body').removeClass('atk-font-adjusted atk-dyslexia-font atk-dark-mode atk-high-contrast');

            // Remove inline styles
            $('body').css('font-size', '');
            $('body *').not('.atk-widget, .atk-widget *').each(function() {
                $(this).css({
                    'font-size': '',
                    'font-family': ''
                });
                $(this).removeAttr('data-atk-scale');
            });

            // Reset checkboxes
            $('#atk-dyslexia').prop('checked', false);
            $('#atk-dark-mode').prop('checked', false);
            $('#atk-high-contrast').prop('checked', false);

            // Update display
            this.updateDisplay();

            // Clear storage
            this.clearUserPreferences();
        },

        /**
         * Update display values
         */
        updateDisplay: function() {
            $('.atk-current-size').text(this.state.fontSize + '%');
        },

        /**
         * Save user preferences
         */
        saveUserPreferences: function() {
            const preferences = {
                fontSize: this.state.fontSize,
                dyslexiaFont: this.state.dyslexiaFont,
                darkMode: this.state.darkMode,
                highContrast: this.state.highContrast
            };

            // Save to localStorage
            try {
                localStorage.setItem(this.constants.STORAGE_KEY, JSON.stringify(preferences));
            } catch (e) {
                console.warn('ATK: Could not save to localStorage', e);
            }

            // Save to cookie as fallback
            document.cookie = this.constants.COOKIE_NAME + '=' + JSON.stringify(preferences) +
                '; max-age=' + (365 * 24 * 60 * 60) + '; path=/; SameSite=Lax';

            // Send to server
            if (this.settings.ajaxUrl) {
                $.ajax({
                    url: this.settings.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'atk_save_settings',
                        nonce: this.settings.nonce,
                        settings: JSON.stringify(preferences)
                    }
                });
            }
        },

        /**
         * Load user preferences
         */
        loadUserPreferences: function() {
            let preferences = null;

            // Try localStorage first
            try {
                const stored = localStorage.getItem(this.constants.STORAGE_KEY);
                if (stored) {
                    preferences = JSON.parse(stored);
                }
            } catch (e) {
                console.warn('ATK: Could not load from localStorage', e);
            }

            // Fallback to cookie
            if (!preferences) {
                const cookie = this.getCookie(this.constants.COOKIE_NAME);
                if (cookie) {
                    try {
                        preferences = JSON.parse(cookie);
                    } catch (e) {
                        console.warn('ATK: Could not parse cookie', e);
                    }
                }
            }

            // Apply preferences if found
            if (preferences) {
                this.state.fontSize = preferences.fontSize || 100;
                this.state.dyslexiaFont = preferences.dyslexiaFont || false;
                this.state.darkMode = preferences.darkMode || false;
                this.state.highContrast = preferences.highContrast || false;
            }
        },

        /**
         * Apply stored settings
         */
        applyStoredSettings: function() {
            // Apply font size
            if (this.state.fontSize !== 100) {
                this.applyFontSize();
            }

            // Apply dyslexia font
            if (this.state.dyslexiaFont) {
                $('#atk-dyslexia').prop('checked', true);
                this.toggleDyslexiaFont(true);
            }

            // Apply dark mode
            if (this.state.darkMode) {
                $('#atk-dark-mode').prop('checked', true);
                this.toggleDarkMode(true);
            }

            // Apply high contrast
            if (this.state.highContrast) {
                $('#atk-high-contrast').prop('checked', true);
                this.toggleHighContrast(true);
            }
        },

        /**
         * Clear user preferences
         */
        clearUserPreferences: function() {
            // Clear localStorage
            try {
                localStorage.removeItem(this.constants.STORAGE_KEY);
            } catch (e) {
                console.warn('ATK: Could not clear localStorage', e);
            }

            // Clear cookie
            document.cookie = this.constants.COOKIE_NAME + '=; max-age=0; path=/';
        },

        /**
         * Get cookie value
         */
        getCookie: function(name) {
            const value = '; ' + document.cookie;
            const parts = value.split('; ' + name + '=');
            if (parts.length === 2) {
                return parts.pop().split(';').shift();
            }
            return null;
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        ATK.init();
    });

    // Make ATK available globally for debugging
    window.AccessibilityToolkit = ATK;

})(jQuery);
