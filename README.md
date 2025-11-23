# WordPress Accessibility Toolkit

A comprehensive WordPress plugin that provides essential accessibility features to make your website more inclusive and accessible to all users.

## Features

### 🔤 Font Size Control
- Increase, decrease, or reset font size
- Maximum font size limit (configurable, default 60px)
- Smooth transitions with proper scaling
- Prevents layout shifts

### 📖 Dyslexia-Friendly Font
- OpenDyslexic font integration with embedded font files
- Forced application across all elements
- Instant toggle on/off
- Improves readability for users with dyslexia

### 🌙 Dark Mode
- Material Design standard colors (#121212 background)
- Customizable background and text colors
- Adjustable background opacity from admin panel
- Smooth visual transitions
- Maintains readability with proper contrast

### ⚫⚪ High Contrast Mode
- WCAG AAA compliant colors (Black background, Yellow text)
- Customizable color scheme from admin panel
- Enhanced visibility for users with visual impairments
- Proper widget positioning (no jumping issues)

### 📍 Flexible Widget Positioning
- **Floating Mode**: Circular button positioned anywhere (customizable px/%)
- **Edge Left/Right**: Rectangle button attached to browser edge
- **Edge Bottom**: Rectangle button attached to bottom edge
- Precise positioning control (pixels or percentages)
- Responsive design for all screen sizes

### 🌍 Internationalization Ready
- Fully translatable with WordPress i18n
- Language files prepared (.pot template included)
- English as default language
- Easy to add translations

## Installation

1. Download the plugin
2. Upload to `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure settings in Settings → Accessibility Toolkit

## Configuration

### Widget Position Settings

Navigate to **Settings → Accessibility Toolkit** in your WordPress admin panel:

1. **Widget Position Mode**: Choose between Floating, Edge Left, Edge Right, or Edge Bottom
2. **Position Offsets**: Set precise positioning using pixels (20px) or percentages (5%)
   - Top Position: Distance from top
   - Bottom Position: Distance from bottom
   - Left Position: Distance from left
   - Right Position: Distance from right
3. **Maximum Font Size**: Set the maximum allowed font size (16-60px)

### Dark Mode Settings

- **Background Color**: Default #121212 (Material Design standard)
- **Text Color**: Default #ffffff
- **Background Opacity**: 0.0 - 1.0 (Default: 0.95)

### High Contrast Settings

- **Background Color**: Default #000000
- **Text Color**: Default #ffff00 (WCAG AAA standard)

## Usage

Users can access the accessibility toolkit via the widget button on your site:

1. Click the accessibility icon to open the panel
2. Adjust font size using A-, A, A+ buttons
3. Toggle dyslexia-friendly font
4. Enable dark mode for reduced eye strain
5. Activate high contrast for better visibility
6. Reset all settings to defaults

All user preferences are automatically saved and restored on subsequent visits.

## Technical Details

### Browser Compatibility
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive
- Touch-friendly interface

### Accessibility Standards
- WCAG 2.1 Level AA compliant
- Keyboard navigation support
- ARIA labels and roles
- Focus management

### Performance
- Lightweight CSS and JavaScript
- Embedded font files (no external requests)
- LocalStorage and cookie fallback
- Efficient DOM manipulation

## File Structure

```
wp-accessibility-plugin/
├── wp-accessibility-toolkit.php    # Main plugin file
├── includes/
│   ├── admin-page.php              # Admin settings page
│   ├── widget.php                  # Frontend widget template
│   └── index.php                   # Security file
├── assets/
│   ├── css/
│   │   ├── admin.css               # Admin styles
│   │   └── frontend.css            # Frontend styles
│   ├── js/
│   │   ├── admin.js                # Admin JavaScript
│   │   └── frontend.js             # Frontend JavaScript
│   ├── fonts/
│   │   └── opendyslexic.css        # OpenDyslexic font with embedded data
│   └── index.php                   # Security file
├── languages/
│   └── accessibility-toolkit.pot   # Translation template
├── LICENSE
└── README.md
```

## Development

### Requirements
- WordPress 5.0 or higher
- PHP 7.0 or higher
- jQuery (included with WordPress)

### Hooks and Filters

The plugin provides several hooks for customization:

```php
// Filter widget position
add_filter('atk_widget_position', function($position) {
    return 'floating'; // or 'edge-left', 'edge-right', 'edge-bottom'
});

// Filter max font size
add_filter('atk_max_font_size', function($size) {
    return 60; // pixels
});
```

## Troubleshooting

### Font size not changing
- Check that JavaScript is enabled
- Verify max font size setting in admin panel
- Clear browser cache

### Dyslexia font not applying
- Ensure the font files are loaded correctly
- Check browser console for errors
- Try disabling theme font overrides

### Widget jumping on high contrast mode
- This has been fixed in the latest version
- Update to the latest version
- Clear browser cache after update

### Dark mode colors not customizing
- Verify opacity setting (should be between 0 and 1)
- Check that custom colors are valid hex codes
- Clear browser cache after saving settings

## License

GPL v2 or later

## Support

For issues, questions, or contributions, please visit:
https://github.com/Midgardsson/wp-accessibility-plugin/issues

## Credits

- OpenDyslexic font by Abelardo Gonzalez
- Material Design color standards by Google
- WCAG guidelines by W3C

## Changelog

### 1.0.0 (2025-11-23)
- Initial release
- Font size controls with max limit
- Dyslexia-friendly font (OpenDyslexic)
- Dark mode with customizable colors and opacity
- High contrast mode with WCAG AAA colors
- Three widget positioning modes
- Internationalization support
- All bugs fixed from initial requirements
