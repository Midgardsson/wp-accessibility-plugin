<?php
/**
 * Admin Settings Page Template
 *
 * @package Accessibility_Toolkit
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap atk-admin-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <?php settings_errors('atk_settings_group'); ?>

    <div class="atk-admin-container">
        <div class="atk-admin-main">
            <form method="post" action="options.php">
                <?php
                settings_fields('atk_settings_group');
                do_settings_sections('accessibility-toolkit');
                submit_button(__('Beállítások mentése', 'accessibility-toolkit'));
                ?>
            </form>
        </div>

        <div class="atk-admin-sidebar">
            <div class="atk-info-box">
                <h3><?php _e('Accessibility Toolkit', 'accessibility-toolkit'); ?></h3>
                <p><strong><?php _e('Verzió:', 'accessibility-toolkit'); ?></strong> <?php echo ATK_VERSION; ?></p>
                <p><?php _e('Ez a plugin segíti a weboldal látogatóit az akadálymentesített böngészésben.', 'accessibility-toolkit'); ?></p>
            </div>

            <div class="atk-info-box">
                <h3><?php _e('Funkciók', 'accessibility-toolkit'); ?></h3>
                <ul class="atk-feature-list">
                    <li>✓ <?php _e('Állítható betűméretek', 'accessibility-toolkit'); ?></li>
                    <li>✓ <?php _e('Dislexia barát betűtípus (OpenDyslexic)', 'accessibility-toolkit'); ?></li>
                    <li>✓ <?php _e('Nagy kontraszt mód', 'accessibility-toolkit'); ?></li>
                    <li>✓ <?php _e('Színek személyre szabása', 'accessibility-toolkit'); ?></li>
                    <li>✓ <?php _e('WCAG 2.1 kompatibilis', 'accessibility-toolkit'); ?></li>
                </ul>
            </div>

            <div class="atk-info-box">
                <h3><?php _e('Használat', 'accessibility-toolkit'); ?></h3>
                <p><?php _e('A plugin aktiválása után automatikusan megjelenik egy akadálymentesítési widget a weboldal jobb alsó sarkában.', 'accessibility-toolkit'); ?></p>
                <p><?php _e('A látogatók az ikorra kattintva állíthatják be a számukra megfelelő akadálymentesítési beállításokat.', 'accessibility-toolkit'); ?></p>
            </div>

            <div class="atk-info-box atk-preview">
                <h3><?php _e('Widget előnézet', 'accessibility-toolkit'); ?></h3>
                <div class="atk-preview-widget">
                    <div class="atk-preview-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2M21 9H15V22H13V16H11V22H9V9H3V7H21V9Z"/>
                        </svg>
                    </div>
                    <p class="atk-preview-label"><?php _e('Az ikon megjelenik a weboldal sarkában', 'accessibility-toolkit'); ?></p>
                </div>
            </div>

            <div class="atk-info-box atk-support">
                <h3><?php _e('Támogatás', 'accessibility-toolkit'); ?></h3>
                <p>
                    <a href="https://github.com/Midgardsson/wp-accessibility-plugin" target="_blank" class="button button-secondary">
                        <?php _e('GitHub Repository', 'accessibility-toolkit'); ?>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
