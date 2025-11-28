<?php
/**
 * Plugin Name: Accessibility Toolkit
 * Plugin URI: https://github.com/Midgardsson/wp-accessibility-plugin
 * Description: Comprehensive accessibility toolkit with dyslexia support, customizable font sizes, and color adjustments for WCAG compliance.
 * Version: 1.0.0
 * Author: Midgardsson
 * Author URI: https://github.com/Midgardsson
 * Text Domain: accessibility-toolkit
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
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
     * Get singleton instance
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
        $this->init_hooks();
    }

    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        // Activation/Deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // Frontend hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('wp_footer', array($this, 'render_widget'));

        // Plugin action links
        add_filter('plugin_action_links_' . ATK_PLUGIN_BASENAME, array($this, 'add_action_links'));
    }

    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        $defaults = array(
            'enabled' => true,
            'font_size_small' => 14,
            'font_size_medium' => 16,
            'font_size_large' => 20,
            'primary_color' => '#000000',
            'background_color' => '#ffffff',
            'link_color' => '#0066cc',
            'widget_position' => 'bottom-right'
        );

        add_option('atk_settings', $defaults);
    }

    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Cleanup if needed
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Accessibility Toolkit', 'accessibility-toolkit'),
            __('Accessibility', 'accessibility-toolkit'),
            'manage_options',
            'accessibility-toolkit',
            array($this, 'render_admin_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('atk_settings_group', 'atk_settings', array($this, 'sanitize_settings'));

        // General settings section
        add_settings_section(
            'atk_general_section',
            __('Általános beállítások', 'accessibility-toolkit'),
            array($this, 'general_section_callback'),
            'accessibility-toolkit'
        );

        // Enabled field
        add_settings_field(
            'enabled',
            __('Plugin engedélyezése', 'accessibility-toolkit'),
            array($this, 'enabled_callback'),
            'accessibility-toolkit',
            'atk_general_section'
        );

        // Font sizes section
        add_settings_section(
            'atk_font_sizes_section',
            __('Betűméretek (pixel)', 'accessibility-toolkit'),
            array($this, 'font_sizes_section_callback'),
            'accessibility-toolkit'
        );

        add_settings_field(
            'font_size_small',
            __('Kis betűméret', 'accessibility-toolkit'),
            array($this, 'font_size_small_callback'),
            'accessibility-toolkit',
            'atk_font_sizes_section'
        );

        add_settings_field(
            'font_size_medium',
            __('Közepes betűméret', 'accessibility-toolkit'),
            array($this, 'font_size_medium_callback'),
            'accessibility-toolkit',
            'atk_font_sizes_section'
        );

        add_settings_field(
            'font_size_large',
            __('Nagy betűméret', 'accessibility-toolkit'),
            array($this, 'font_size_large_callback'),
            'accessibility-toolkit',
            'atk_font_sizes_section'
        );

        // Colors section
        add_settings_section(
            'atk_colors_section',
            __('Színek', 'accessibility-toolkit'),
            array($this, 'colors_section_callback'),
            'accessibility-toolkit'
        );

        add_settings_field(
            'primary_color',
            __('Szöveg szín', 'accessibility-toolkit'),
            array($this, 'primary_color_callback'),
            'accessibility-toolkit',
            'atk_colors_section'
        );

        add_settings_field(
            'background_color',
            __('Háttérszín', 'accessibility-toolkit'),
            array($this, 'background_color_callback'),
            'accessibility-toolkit',
            'atk_colors_section'
        );

        add_settings_field(
            'link_color',
            __('Link szín', 'accessibility-toolkit'),
            array($this, 'link_color_callback'),
            'accessibility-toolkit',
            'atk_colors_section'
        );
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $sanitized = array();

        $sanitized['enabled'] = isset($input['enabled']) ? true : false;
        $sanitized['font_size_small'] = absint($input['font_size_small']);
        $sanitized['font_size_medium'] = absint($input['font_size_medium']);
        $sanitized['font_size_large'] = absint($input['font_size_large']);
        $sanitized['primary_color'] = sanitize_hex_color($input['primary_color']);
        $sanitized['background_color'] = sanitize_hex_color($input['background_color']);
        $sanitized['link_color'] = sanitize_hex_color($input['link_color']);
        $sanitized['widget_position'] = sanitize_text_field($input['widget_position']);

        return $sanitized;
    }

    /**
     * Settings field callbacks
     */
    public function general_section_callback() {
        echo '<p>' . __('Alapvető plugin beállítások.', 'accessibility-toolkit') . '</p>';
    }

    public function enabled_callback() {
        $options = get_option('atk_settings');
        $checked = isset($options['enabled']) && $options['enabled'] ? 'checked' : '';
        echo '<label><input type="checkbox" name="atk_settings[enabled]" value="1" ' . $checked . '> ' . __('Accessibility widget megjelenítése a frontenden', 'accessibility-toolkit') . '</label>';
    }

    public function font_sizes_section_callback() {
        echo '<p>' . __('Állítsa be a betűméreteket pixelben a gyengénlátók számára.', 'accessibility-toolkit') . '</p>';
    }

    public function font_size_small_callback() {
        $options = get_option('atk_settings');
        $value = isset($options['font_size_small']) ? $options['font_size_small'] : 14;
        echo '<input type="number" name="atk_settings[font_size_small]" value="' . esc_attr($value) . '" min="10" max="30" step="1"> px';
    }

    public function font_size_medium_callback() {
        $options = get_option('atk_settings');
        $value = isset($options['font_size_medium']) ? $options['font_size_medium'] : 16;
        echo '<input type="number" name="atk_settings[font_size_medium]" value="' . esc_attr($value) . '" min="10" max="30" step="1"> px';
    }

    public function font_size_large_callback() {
        $options = get_option('atk_settings');
        $value = isset($options['font_size_large']) ? $options['font_size_large'] : 20;
        echo '<input type="number" name="atk_settings[font_size_large]" value="' . esc_attr($value) . '" min="10" max="30" step="1"> px';
    }

    public function colors_section_callback() {
        echo '<p>' . __('Állítsa be a színeket az akadálymentesítéshez.', 'accessibility-toolkit') . '</p>';
    }

    public function primary_color_callback() {
        $options = get_option('atk_settings');
        $value = isset($options['primary_color']) ? $options['primary_color'] : '#000000';
        echo '<input type="color" name="atk_settings[primary_color]" value="' . esc_attr($value) . '">';
    }

    public function background_color_callback() {
        $options = get_option('atk_settings');
        $value = isset($options['background_color']) ? $options['background_color'] : '#ffffff';
        echo '<input type="color" name="atk_settings[background_color]" value="' . esc_attr($value) . '">';
    }

    public function link_color_callback() {
        $options = get_option('atk_settings');
        $value = isset($options['link_color']) ? $options['link_color'] : '#0066cc';
        echo '<input type="color" name="atk_settings[link_color]" value="' . esc_attr($value) . '">';
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        require_once ATK_PLUGIN_DIR . 'admin/settings.php';
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if ('settings_page_accessibility-toolkit' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'atk-admin-style',
            ATK_PLUGIN_URL . 'admin/admin.css',
            array(),
            ATK_VERSION
        );
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        $options = get_option('atk_settings');

        // Only load if enabled
        if (!isset($options['enabled']) || !$options['enabled']) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style(
            'atk-widget-style',
            ATK_PLUGIN_URL . 'assets/css/widget.css',
            array(),
            ATK_VERSION
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'atk-widget-script',
            ATK_PLUGIN_URL . 'assets/js/widget.js',
            array('jquery'),
            ATK_VERSION,
            true
        );

        // Pass settings to JavaScript
        wp_localize_script('atk-widget-script', 'atkSettings', array(
            'fontSizeSmall' => $options['font_size_small'],
            'fontSizeMedium' => $options['font_size_medium'],
            'fontSizeLarge' => $options['font_size_large'],
            'primaryColor' => $options['primary_color'],
            'backgroundColor' => $options['background_color'],
            'linkColor' => $options['link_color'],
            'fontUrl' => ATK_PLUGIN_URL . 'assets/fonts/'
        ));
    }

    /**
     * Render accessibility widget on frontend
     */
    public function render_widget() {
        $options = get_option('atk_settings');

        // Only render if enabled
        if (!isset($options['enabled']) || !$options['enabled']) {
            return;
        }

        ?>
        <div id="atk-widget" class="atk-widget">
            <button id="atk-toggle" class="atk-toggle" aria-label="<?php esc_attr_e('Akadálymentesítési beállítások', 'accessibility-toolkit'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2M21 9H15V22H13V16H11V22H9V9H3V7H21V9Z"/>
                </svg>
            </button>

            <div id="atk-panel" class="atk-panel" style="display: none;">
                <div class="atk-panel-header">
                    <h3><?php _e('Akadálymentesítés', 'accessibility-toolkit'); ?></h3>
                    <button id="atk-close" class="atk-close" aria-label="<?php esc_attr_e('Bezárás', 'accessibility-toolkit'); ?>">&times;</button>
                </div>

                <div class="atk-panel-content">
                    <!-- Font size controls -->
                    <div class="atk-control-group">
                        <label><?php _e('Betűméret:', 'accessibility-toolkit'); ?></label>
                        <div class="atk-button-group">
                            <button class="atk-font-size-btn" data-size="small">
                                <?php _e('Kicsi', 'accessibility-toolkit'); ?>
                            </button>
                            <button class="atk-font-size-btn" data-size="medium">
                                <?php _e('Közepes', 'accessibility-toolkit'); ?>
                            </button>
                            <button class="atk-font-size-btn" data-size="large">
                                <?php _e('Nagy', 'accessibility-toolkit'); ?>
                            </button>
                        </div>
                    </div>

                    <!-- Dyslexia font toggle -->
                    <div class="atk-control-group">
                        <label><?php _e('Dislexia barát betűtípus:', 'accessibility-toolkit'); ?></label>
                        <button id="atk-dyslexia-toggle" class="atk-toggle-btn">
                            <?php _e('Bekapcsolás', 'accessibility-toolkit'); ?>
                        </button>
                    </div>

                    <!-- High contrast toggle -->
                    <div class="atk-control-group">
                        <label><?php _e('Nagy kontraszt:', 'accessibility-toolkit'); ?></label>
                        <button id="atk-contrast-toggle" class="atk-toggle-btn">
                            <?php _e('Bekapcsolás', 'accessibility-toolkit'); ?>
                        </button>
                    </div>

                    <!-- Reset button -->
                    <div class="atk-control-group">
                        <button id="atk-reset" class="atk-reset-btn">
                            <?php _e('Visszaállítás', 'accessibility-toolkit'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Add plugin action links
     */
    public function add_action_links($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=accessibility-toolkit') . '">' . __('Beállítások', 'accessibility-toolkit') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}

// Initialize the plugin
function accessibility_toolkit_init() {
    return Accessibility_Toolkit::get_instance();
}

// Start the plugin
add_action('plugins_loaded', 'accessibility_toolkit_init');
