<?php
/**
 * Plugin Name: Accessibility Toolkit
 * Plugin URI: https://github.com/Midgardsson/wp-accessibility-plugin
 * Description: Comprehensive accessibility toolkit with dyslexia font, dark mode, high contrast, and font size controls.
 * Version: 1.0.0
 * Author: Midgardsson
 * Text Domain: accessibility-toolkit
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ATK_VERSION', '1.0.0');
define('ATK_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ATK_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ATK_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Accessibility Toolkit Class
 */
class Accessibility_Toolkit {

    /**
     * Instance of this class
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Load plugin text domain
        add_action('plugins_loaded', array($this, 'load_textdomain'));

        // Admin hooks
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        }

        // Frontend hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('wp_footer', array($this, 'render_widget'));
        add_action('wp_ajax_atk_save_settings', array($this, 'ajax_save_settings'));
        add_action('wp_ajax_nopriv_atk_save_settings', array($this, 'ajax_save_settings'));
    }

    /**
     * Load plugin text domain for translations
     */
    public function load_textdomain() {
        load_plugin_textdomain('accessibility-toolkit', false, dirname(ATK_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Accessibility Toolkit Settings', 'accessibility-toolkit'),
            __('Accessibility Toolkit', 'accessibility-toolkit'),
            'manage_options',
            'accessibility-toolkit',
            array($this, 'render_admin_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('atk_settings_group', 'atk_settings', array($this, 'sanitize_settings'));
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $sanitized = array();

        // Widget position
        $sanitized['widget_position'] = isset($input['widget_position']) ? sanitize_text_field($input['widget_position']) : 'floating';

        // Position offsets
        $sanitized['position_top'] = isset($input['position_top']) ? sanitize_text_field($input['position_top']) : '20px';
        $sanitized['position_bottom'] = isset($input['position_bottom']) ? sanitize_text_field($input['position_bottom']) : 'auto';
        $sanitized['position_left'] = isset($input['position_left']) ? sanitize_text_field($input['position_left']) : 'auto';
        $sanitized['position_right'] = isset($input['position_right']) ? sanitize_text_field($input['position_right']) : '20px';

        // Font size limits
        $sanitized['max_font_size'] = isset($input['max_font_size']) ? absint($input['max_font_size']) : 60;

        // Dark mode settings
        $sanitized['dark_bg_color'] = isset($input['dark_bg_color']) ? sanitize_hex_color($input['dark_bg_color']) : '#121212';
        $sanitized['dark_text_color'] = isset($input['dark_text_color']) ? sanitize_hex_color($input['dark_text_color']) : '#ffffff';
        $sanitized['dark_bg_opacity'] = isset($input['dark_bg_opacity']) ? floatval($input['dark_bg_opacity']) : 0.95;

        // High contrast settings
        $sanitized['high_contrast_bg'] = isset($input['high_contrast_bg']) ? sanitize_hex_color($input['high_contrast_bg']) : '#000000';
        $sanitized['high_contrast_text'] = isset($input['high_contrast_text']) ? sanitize_hex_color($input['high_contrast_text']) : '#ffff00';

        return $sanitized;
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ('settings_page_accessibility-toolkit' !== $hook) {
            return;
        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('atk-admin-css', ATK_PLUGIN_URL . 'assets/css/admin.css', array(), ATK_VERSION);
        wp_enqueue_script('atk-admin-js', ATK_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'wp-color-picker'), ATK_VERSION, true);
    }

    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts() {
        // Enqueue OpenDyslexic font
        wp_enqueue_style('atk-opendyslexic-font', ATK_PLUGIN_URL . 'assets/fonts/opendyslexic.css', array(), ATK_VERSION);

        // Enqueue main styles
        wp_enqueue_style('atk-frontend-css', ATK_PLUGIN_URL . 'assets/css/frontend.css', array(), ATK_VERSION);

        // Enqueue main script
        wp_enqueue_script('atk-frontend-js', ATK_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), ATK_VERSION, true);

        // Pass settings to JavaScript
        $settings = $this->get_settings();
        wp_localize_script('atk-frontend-js', 'atkSettings', array(
            'widgetPosition' => $settings['widget_position'],
            'positionTop' => $settings['position_top'],
            'positionBottom' => $settings['position_bottom'],
            'positionLeft' => $settings['position_left'],
            'positionRight' => $settings['position_right'],
            'maxFontSize' => $settings['max_font_size'],
            'darkBgColor' => $settings['dark_bg_color'],
            'darkTextColor' => $settings['dark_text_color'],
            'darkBgOpacity' => $settings['dark_bg_opacity'],
            'highContrastBg' => $settings['high_contrast_bg'],
            'highContrastText' => $settings['high_contrast_text'],
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('atk_nonce')
        ));
    }

    /**
     * Get settings with defaults
     */
    private function get_settings() {
        $defaults = array(
            'widget_position' => 'floating',
            'position_top' => '20px',
            'position_bottom' => 'auto',
            'position_left' => 'auto',
            'position_right' => '20px',
            'max_font_size' => 60,
            'dark_bg_color' => '#121212',
            'dark_text_color' => '#ffffff',
            'dark_bg_opacity' => 0.95,
            'high_contrast_bg' => '#000000',
            'high_contrast_text' => '#ffff00'
        );

        $settings = get_option('atk_settings', array());
        return wp_parse_args($settings, $defaults);
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = $this->get_settings();
        include ATK_PLUGIN_DIR . 'includes/admin-page.php';
    }

    /**
     * Render widget on frontend
     */
    public function render_widget() {
        $settings = $this->get_settings();
        include ATK_PLUGIN_DIR . 'includes/widget.php';
    }

    /**
     * AJAX save settings
     */
    public function ajax_save_settings() {
        check_ajax_referer('atk_nonce', 'nonce');

        $user_settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) : array();

        // Store user preferences in cookie
        setcookie('atk_user_settings', json_encode($user_settings), time() + (86400 * 365), '/');

        wp_send_json_success();
    }
}

// Initialize plugin
Accessibility_Toolkit::get_instance();
