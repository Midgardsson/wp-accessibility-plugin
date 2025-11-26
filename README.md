=== Accessibility Toolkit ===
Contributors: midgardsson
Tags: accessibility, dyslexia, dark-mode, high-contrast, wcag
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Comprehensive accessibility toolkit with dyslexia-friendly font, dark mode, high contrast mode, and adjustable font size controls.

== Description ==

Make your WordPress website accessible to all users with this comprehensive accessibility toolkit. Perfect for improving inclusivity and meeting WCAG 2.1 Level AA compliance standards.

= Key Features =

**🔤 Font Size Control**
Increase, decrease, or reset font size with easy-to-use buttons. Maximum font size limit prevents layout issues while ensuring readability.

**📖 Dyslexia-Friendly Font**
Toggle OpenDyslexic font instantly across your entire site. The embedded font improves readability for users with dyslexia without external requests.

**🌙 Dark Mode**
Material Design standard dark mode (#121212 background) with customizable colors and adjustable opacity. Reduces eye strain during extended reading sessions.

**⚫⚪ High Contrast Mode**
WCAG AAA compliant high contrast mode with black background and yellow text. Enhances visibility for users with visual impairments.

**📍 Flexible Widget Positioning**
Choose from four positioning modes:
* Floating: Circular button positioned anywhere (customizable px/%)
* Edge Left: Rectangle button attached to left edge
* Edge Right: Rectangle button attached to right edge  
* Edge Bottom: Rectangle button attached to bottom edge

**🌍 Translation Ready**
Fully internationalized with WordPress i18n standards. English included, easy to add your language.

= Accessibility Standards =

* WCAG 2.1 Level AA compliant
* Keyboard navigation support
* ARIA labels and roles
* Focus management
* High contrast mode meets WCAG AAA standards

= Performance =

* Lightweight CSS and JavaScript
* Embedded font files (no external requests)
* LocalStorage with cookie fallback
* Efficient DOM manipulation
* No impact on page load times

= User-Friendly =

All user preferences are automatically saved and restored on subsequent visits using browser storage.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/accessibility-toolkit/` directory, or install through WordPress plugins screen
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to Settings → Accessibility Toolkit to configure
4. The accessibility widget will appear on your site's frontend

== Frequently Asked Questions ==

= Does this work with any theme? =

Yes! The Accessibility Toolkit is designed to work with any WordPress theme. The widget is positioned independently and doesn't conflict with theme layouts.

= Are user preferences saved? =

Yes, all accessibility settings are saved in the user's browser using localStorage (with cookie fallback) and persist across sessions.

= Can I customize the colors? =

Absolutely! Navigate to Settings → Accessibility Toolkit in your WordPress admin to customize:
* Dark mode background and text colors
* Dark mode background opacity
* High contrast mode colors
* Widget positioning

= What is the maximum font size? =

By default, the maximum font size is 60px to prevent layout issues. You can adjust this in the plugin settings (range: 16-60px).

= Is this WCAG compliant? =

Yes! The plugin supports WCAG 2.1 Level AA standards, and the high contrast mode meets WCAG AAA standards. Full site compliance depends on your overall content and structure.

= Does it work on mobile devices? =

Yes, the plugin is fully responsive and touch-friendly. The widget adapts to all screen sizes.

= Will it slow down my site? =

No. The plugin is lightweight with minimal CSS and JavaScript. Font files are embedded to avoid external requests.

== Screenshots ==

1. Accessibility widget with all controls visible
2. Dark mode enabled with Material Design colors
3. High contrast mode (WCAG AAA compliant)
4. Font size controls in action
5. Dyslexia-friendly font toggle
6. Admin settings panel with positioning options

== Configuration ==

After activation, navigate to **Settings → Accessibility Toolkit**:

**Widget Position Settings**
* Choose positioning mode (Floating, Edge Left, Edge Right, Edge Bottom)
* Set precise offsets using pixels or percentages
* Configure maximum font size limit

**Dark Mode Settings**
* Customize background color (default: #121212)
* Set text color (default: #ffffff)
* Adjust background opacity (0.0 - 1.0)

**High Contrast Settings**
* Customize background color (default: #000000)
* Set text color (default: #ffff00)

== Changelog ==

= 1.0.0 (2025-11-23) =
* Initial release
* Font size controls with configurable max limit (16-60px)
* Dyslexia-friendly font toggle with embedded OpenDyslexic
* Dark mode with Material Design colors and adjustable opacity
* High contrast mode with WCAG AAA compliant colors
* Four widget positioning modes (Floating, Edge Left/Right, Edge Bottom)
* Precise positioning control (pixels or percentages)
* Internationalization support with .pot template
* LocalStorage with cookie fallback
* Keyboard navigation support
* ARIA labels and semantic HTML
* Mobile responsive design

== Upgrade Notice ==

= 1.0.0 =
Initial release of Accessibility Toolkit. Essential accessibility features for any WordPress site.

== Technical Details ==

**Browser Compatibility**
* Chrome, Firefox, Safari, Edge (latest versions)
* Mobile browsers (iOS Safari, Chrome Mobile)
* Touch-friendly interface

**Requirements**
* WordPress 5.0 or higher
* PHP 7.0 or higher
* jQuery (included with WordPress)

**File Structure**
* Clean, organized codebase
* Follows WordPress coding standards
* Security best practices (nonces, escaping, sanitization)
* Translation ready

== Support ==

For support, feature requests, or bug reports:
* GitHub: https://github.com/Midgardsson/wp-accessibility-plugin/issues
* WordPress.org Support Forum

== Credits ==

* OpenDyslexic font by Abelardo Gonzalez
* Material Design color standards by Google
* WCAG guidelines by W3C
* Developed by Midgardsson

== Privacy ==

This plugin stores user accessibility preferences locally in the browser using:
* localStorage (primary method)
* Cookies (fallback method)

No data is sent to external servers. All preferences remain on the user's device.
