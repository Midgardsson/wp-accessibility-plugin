<?php
/**
 * Plugin Name: WP Accessibility Widget
 * Plugin URI: https://github.com/Midgardsson/wp-accessibility-plugin
 * Description: Accessibility widget with font size controls and custom font support
 * Version: 1.0.0
 * Author: Midgardsson
 * License: GPL v2 or later
 * Text Domain: wp-accessibility-widget
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WP_ACCESSIBILITY_WIDGET_VERSION', '1.0.0');
define('WP_ACCESSIBILITY_WIDGET_PATH', plugin_dir_path(__FILE__));
define('WP_ACCESSIBILITY_WIDGET_URL', plugin_dir_url(__FILE__));
// Font file path: assets/fonts/OpenDyslexic-Regular.ttf
define('WP_ACCESSIBILITY_WIDGET_FONT_PATH', WP_ACCESSIBILITY_WIDGET_PATH . 'assets/fonts/OpenDyslexic-Regular.ttf');

class WP_Accessibility_Widget {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_footer', array($this, 'render_widget'));
        add_action('wp_ajax_reset_accessibility_settings', array($this, 'reset_settings'));
        add_action('wp_ajax_nopriv_reset_accessibility_settings', array($this, 'reset_settings'));
    }

    /**
     * Enqueue plugin assets
     */
    public function enqueue_assets() {
        // Enqueue CSS
        wp_enqueue_style(
            'wp-accessibility-widget',
            WP_ACCESSIBILITY_WIDGET_URL . 'assets/css/widget.css',
            array(),
            WP_ACCESSIBILITY_WIDGET_VERSION
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'wp-accessibility-widget',
            WP_ACCESSIBILITY_WIDGET_URL . 'assets/js/widget.js',
            array('jquery'),
            WP_ACCESSIBILITY_WIDGET_VERSION,
            true
        );

        // Pass AJAX URL to JavaScript
        wp_localize_script('wp-accessibility-widget', 'wpAccessibilityWidget', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'fontUrl' => WP_ACCESSIBILITY_WIDGET_URL . 'assets/fonts/OpenDyslexic-Regular.ttf'
        ));
    }

    /**
     * Render the accessibility widget
     */
    public function render_widget() {
        ?>
        <div id="wp-accessibility-widget" class="wp-accessibility-widget">
            <div class="widget-header">
                <span class="widget-title">Akadálymentesítés</span>
                <button class="widget-toggle" aria-label="Toggle widget">
                    <span class="toggle-icon">⚙️</span>
                </button>
            </div>
            <div class="widget-content">
                <div class="control-group">
                    <label>Betűméret:</label>
                    <div class="button-group">
                        <button class="control-btn" id="decrease-font" aria-label="Decrease font size">A-</button>
                        <button class="control-btn" id="reset-font" aria-label="Reset font size">A</button>
                        <button class="control-btn" id="increase-font" aria-label="Increase font size">A+</button>
                    </div>
                </div>
                <div class="control-group">
                    <label>
                        <input type="checkbox" id="toggle-dyslexic-font">
                        Diszlexia-barát betűtípus
                    </label>
                </div>
                <div class="control-group">
                    <button class="control-btn reset-btn" id="reset-all" aria-label="Reset all settings">
                        Visszaállítás
                    </button>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX handler for resetting settings
     */
    public function reset_settings() {
        wp_send_json_success(array('message' => 'Settings reset successfully'));
    }
}

// Initialize the plugin
function wp_accessibility_widget_init() {
    return WP_Accessibility_Widget::get_instance();
}
add_action('plugins_loaded', 'wp_accessibility_widget_init');
