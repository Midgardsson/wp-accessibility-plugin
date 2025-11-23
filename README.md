# WP Accessibility Widget

WordPress plugin for website accessibility with font size controls and dyslexic-friendly font support.

## Features

- ✅ **Font Size Controls**: Increase, decrease, and reset font sizes
- ✅ **Dyslexic-Friendly Font**: Toggle OpenDyslexic font for better readability
- ✅ **Draggable Widget**: Move the widget anywhere on the screen
- ✅ **Settings Persistence**: Saves user preferences in localStorage
- ✅ **Responsive Design**: Works on desktop and mobile devices
- ✅ **Accessibility Focused**: Keyboard navigation and ARIA labels

## Fixed Issues

### 1. Widget Positioning ✅
**Problem**: Widget was overflowing the screen
**Solution**: Set default position to `top: 10%, left: 10%`
- File: `assets/css/widget.css:13-14`

### 2. Font Path Documentation ✅
**Problem**: Font file path was not documented
**Solution**: Added font path comments in source code:
- PHP: `wp-accessibility-widget.php:17` - `WP_ACCESSIBILITY_WIDGET_FONT_PATH`
- CSS: `assets/css/widget.css:6` - `@font-face` definition
- README: `assets/fonts/README.md` - Installation guide

### 3. Font Registration ✅
**Problem**: Font was not properly registered
**Solution**: Added proper `@font-face` registration in CSS with fallback fonts
- File: `assets/css/widget.css:6-12`

### 4. Font Size Reset Functionality ✅
**Problem**: Font size reset button didn't work properly - size got stuck
**Solution**: Complete rewrite of reset functionality:
- Properly resets to default 'medium' size
- Removes all font size classes before applying new one
- Visual feedback with checkmark on reset
- File: `assets/js/widget.js:177-192`

## Installation

1. Download or clone this repository to your WordPress plugins directory:
   ```bash
   cd wp-content/plugins/
   git clone https://github.com/Midgardsson/wp-accessibility-plugin.git
   ```

2. Download the OpenDyslexic font:
   - Visit: https://opendyslexic.org/
   - Download and extract `OpenDyslexic-Regular.ttf`
   - Place it in: `assets/fonts/OpenDyslexic-Regular.ttf`

3. Activate the plugin in WordPress admin panel

## File Structure

```
wp-accessibility-plugin/
├── wp-accessibility-widget.php    # Main plugin file
├── assets/
│   ├── css/
│   │   └── widget.css            # Widget styles (includes @font-face)
│   ├── js/
│   │   └── widget.js             # Widget functionality
│   └── fonts/
│       ├── README.md             # Font installation guide
│       ├── .gitkeep              # Git directory placeholder
│       └── OpenDyslexic-Regular.ttf  # Font file (download separately)
├── LICENSE
└── README.md
```

## Usage

Once activated, the accessibility widget will appear on all public pages:

1. **Font Size Control**:
   - Click `A-` to decrease font size
   - Click `A` to reset to default size ← **Fixed: Now works properly!**
   - Click `A+` to increase font size

2. **Dyslexic Font**:
   - Check the box to enable OpenDyslexic font
   - Uncheck to return to default font

3. **Reset All**:
   - Click "Visszaállítás" to reset all settings to defaults
   - Confirms before resetting

4. **Move Widget**:
   - Drag the widget header to reposition
   - Position is saved automatically

## Technical Details

### Font Size Levels
- Small: 14px
- **Medium: 16px (default)**
- Large: 18px
- X-Large: 20px
- XX-Large: 22px

### Browser Compatibility
- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (with polyfills)

### Dependencies
- jQuery (included in WordPress)

## Development

### Constants Defined
- `WP_ACCESSIBILITY_WIDGET_VERSION`: Plugin version
- `WP_ACCESSIBILITY_WIDGET_PATH`: Plugin directory path
- `WP_ACCESSIBILITY_WIDGET_URL`: Plugin URL
- `WP_ACCESSIBILITY_WIDGET_FONT_PATH`: Font file path (assets/fonts/OpenDyslexic-Regular.ttf)

### Hooks Used
- `wp_enqueue_scripts`: Enqueue CSS and JS
- `wp_footer`: Render widget HTML
- `wp_ajax_reset_accessibility_settings`: AJAX handler for reset

## License

GPL v2 or later

## Author

Midgardsson

## Links

- GitHub: https://github.com/Midgardsson/wp-accessibility-plugin
- OpenDyslexic Font: https://opendyslexic.org/
