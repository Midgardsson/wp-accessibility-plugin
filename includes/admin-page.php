<?php
/**
 * Admin Settings Page Template
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields('atk_settings_group');
        $settings = get_option('atk_settings', array());
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
        $settings = wp_parse_args($settings, $defaults);
        ?>

        <table class="form-table">
            <!-- Widget Position -->
            <tr>
                <th scope="row">
                    <label for="widget_position"><?php _e('Widget Position Mode', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <select name="atk_settings[widget_position]" id="widget_position" class="atk-position-select">
                        <option value="floating" <?php selected($settings['widget_position'], 'floating'); ?>>
                            <?php _e('Floating (Circle)', 'accessibility-toolkit'); ?>
                        </option>
                        <option value="edge-left" <?php selected($settings['widget_position'], 'edge-left'); ?>>
                            <?php _e('Edge Left (Rectangle)', 'accessibility-toolkit'); ?>
                        </option>
                        <option value="edge-right" <?php selected($settings['widget_position'], 'edge-right'); ?>>
                            <?php _e('Edge Right (Rectangle)', 'accessibility-toolkit'); ?>
                        </option>
                        <option value="edge-bottom" <?php selected($settings['widget_position'], 'edge-bottom'); ?>>
                            <?php _e('Edge Bottom (Rectangle)', 'accessibility-toolkit'); ?>
                        </option>
                    </select>
                    <p class="description">
                        <?php _e('Choose how the widget is positioned on the page.', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Position Top -->
            <tr class="atk-position-field" data-positions="floating,edge-left,edge-right">
                <th scope="row">
                    <label for="position_top"><?php _e('Top Position', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[position_top]" id="position_top"
                           value="<?php echo esc_attr($settings['position_top']); ?>" class="regular-text">
                    <p class="description">
                        <?php _e('Distance from top (e.g., 20px, 10%, auto)', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Position Bottom -->
            <tr class="atk-position-field" data-positions="edge-bottom">
                <th scope="row">
                    <label for="position_bottom"><?php _e('Bottom Position', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[position_bottom]" id="position_bottom"
                           value="<?php echo esc_attr($settings['position_bottom']); ?>" class="regular-text">
                    <p class="description">
                        <?php _e('Distance from bottom (e.g., 20px, 10%, auto)', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Position Left -->
            <tr class="atk-position-field" data-positions="floating,edge-left">
                <th scope="row">
                    <label for="position_left"><?php _e('Left Position', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[position_left]" id="position_left"
                           value="<?php echo esc_attr($settings['position_left']); ?>" class="regular-text">
                    <p class="description">
                        <?php _e('Distance from left (e.g., 20px, 10%, auto)', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Position Right -->
            <tr class="atk-position-field" data-positions="floating,edge-right,edge-bottom">
                <th scope="row">
                    <label for="position_right"><?php _e('Right Position', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[position_right]" id="position_right"
                           value="<?php echo esc_attr($settings['position_right']); ?>" class="regular-text">
                    <p class="description">
                        <?php _e('Distance from right (e.g., 20px, 10%, auto)', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Max Font Size -->
            <tr>
                <th scope="row">
                    <label for="max_font_size"><?php _e('Maximum Font Size', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="number" name="atk_settings[max_font_size]" id="max_font_size"
                           value="<?php echo esc_attr($settings['max_font_size']); ?>" min="16" max="60" step="1">
                    <span>px</span>
                    <p class="description">
                        <?php _e('Maximum allowed font size (16-60px). Default: 60px', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Dark Mode Section -->
            <tr>
                <th colspan="2">
                    <h2><?php _e('Dark Mode Settings', 'accessibility-toolkit'); ?></h2>
                </th>
            </tr>

            <!-- Dark Mode Background Color -->
            <tr>
                <th scope="row">
                    <label for="dark_bg_color"><?php _e('Background Color', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[dark_bg_color]" id="dark_bg_color"
                           value="<?php echo esc_attr($settings['dark_bg_color']); ?>" class="atk-color-picker">
                    <p class="description">
                        <?php _e('Dark mode background color. Default: #121212 (Material Design standard)', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Dark Mode Text Color -->
            <tr>
                <th scope="row">
                    <label for="dark_text_color"><?php _e('Text Color', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[dark_text_color]" id="dark_text_color"
                           value="<?php echo esc_attr($settings['dark_text_color']); ?>" class="atk-color-picker">
                    <p class="description">
                        <?php _e('Dark mode text color. Default: #ffffff', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- Dark Mode Background Opacity -->
            <tr>
                <th scope="row">
                    <label for="dark_bg_opacity"><?php _e('Background Opacity', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="number" name="atk_settings[dark_bg_opacity]" id="dark_bg_opacity"
                           value="<?php echo esc_attr($settings['dark_bg_opacity']); ?>" min="0" max="1" step="0.05">
                    <p class="description">
                        <?php _e('Background opacity (0.0 - 1.0). Default: 0.95', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- High Contrast Section -->
            <tr>
                <th colspan="2">
                    <h2><?php _e('High Contrast Settings', 'accessibility-toolkit'); ?></h2>
                </th>
            </tr>

            <!-- High Contrast Background -->
            <tr>
                <th scope="row">
                    <label for="high_contrast_bg"><?php _e('Background Color', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[high_contrast_bg]" id="high_contrast_bg"
                           value="<?php echo esc_attr($settings['high_contrast_bg']); ?>" class="atk-color-picker">
                    <p class="description">
                        <?php _e('High contrast background color. Default: #000000', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>

            <!-- High Contrast Text -->
            <tr>
                <th scope="row">
                    <label for="high_contrast_text"><?php _e('Text Color', 'accessibility-toolkit'); ?></label>
                </th>
                <td>
                    <input type="text" name="atk_settings[high_contrast_text]" id="high_contrast_text"
                           value="<?php echo esc_attr($settings['high_contrast_text']); ?>" class="atk-color-picker">
                    <p class="description">
                        <?php _e('High contrast text color. Default: #ffff00 (WCAG AAA standard)', 'accessibility-toolkit'); ?>
                    </p>
                </td>
            </tr>
        </table>

        <?php submit_button(__('Save Settings', 'accessibility-toolkit')); ?>
    </form>
</div>
