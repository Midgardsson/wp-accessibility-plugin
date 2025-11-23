<?php
/**
 * Frontend Widget Template
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

$widget_position = isset($settings['widget_position']) ? $settings['widget_position'] : 'floating';
?>

<div id="atk-widget" class="atk-widget atk-widget-<?php echo esc_attr($widget_position); ?>" role="complementary" aria-label="<?php esc_attr_e('Accessibility Toolkit', 'accessibility-toolkit'); ?>">
    <button class="atk-toggle-button" aria-expanded="false" aria-controls="atk-panel" aria-label="<?php esc_attr_e('Open Accessibility Toolkit', 'accessibility-toolkit'); ?>">
        <svg class="atk-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" aria-hidden="true">
            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9H15V22H13V16H11V22H9V9H3V7H21V9Z"/>
        </svg>
        <span class="atk-icon-text" aria-hidden="true">♿</span>
    </button>

    <div id="atk-panel" class="atk-panel" aria-hidden="true">
        <div class="atk-panel-header">
            <h2><?php _e('Accessibility Options', 'accessibility-toolkit'); ?></h2>
            <button class="atk-close-button" aria-label="<?php esc_attr_e('Close Accessibility Toolkit', 'accessibility-toolkit'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>

        <div class="atk-panel-content">
            <!-- Font Size Controls -->
            <div class="atk-control-group">
                <label class="atk-control-label"><?php _e('Font Size', 'accessibility-toolkit'); ?></label>
                <div class="atk-button-group">
                    <button class="atk-btn atk-btn-decrease" data-action="decrease-font" aria-label="<?php esc_attr_e('Decrease font size', 'accessibility-toolkit'); ?>">
                        <span aria-hidden="true">A-</span>
                    </button>
                    <button class="atk-btn atk-btn-reset" data-action="reset-font" aria-label="<?php esc_attr_e('Reset font size', 'accessibility-toolkit'); ?>">
                        <span aria-hidden="true">A</span>
                    </button>
                    <button class="atk-btn atk-btn-increase" data-action="increase-font" aria-label="<?php esc_attr_e('Increase font size', 'accessibility-toolkit'); ?>">
                        <span aria-hidden="true">A+</span>
                    </button>
                </div>
                <div class="atk-font-size-display">
                    <span><?php _e('Current:', 'accessibility-toolkit'); ?> <strong class="atk-current-size">100%</strong></span>
                </div>
            </div>

            <!-- Dyslexia Font -->
            <div class="atk-control-group">
                <label class="atk-control-label">
                    <input type="checkbox" class="atk-checkbox" data-action="toggle-dyslexia" id="atk-dyslexia">
                    <span><?php _e('Dyslexia-Friendly Font', 'accessibility-toolkit'); ?></span>
                </label>
            </div>

            <!-- Dark Mode -->
            <div class="atk-control-group">
                <label class="atk-control-label">
                    <input type="checkbox" class="atk-checkbox" data-action="toggle-dark-mode" id="atk-dark-mode">
                    <span><?php _e('Dark Mode', 'accessibility-toolkit'); ?></span>
                </label>
            </div>

            <!-- High Contrast -->
            <div class="atk-control-group">
                <label class="atk-control-label">
                    <input type="checkbox" class="atk-checkbox" data-action="toggle-high-contrast" id="atk-high-contrast">
                    <span><?php _e('High Contrast', 'accessibility-toolkit'); ?></span>
                </label>
            </div>

            <!-- Reset All -->
            <div class="atk-control-group">
                <button class="atk-btn atk-btn-full atk-btn-reset-all" data-action="reset-all">
                    <?php _e('Reset All Settings', 'accessibility-toolkit'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
