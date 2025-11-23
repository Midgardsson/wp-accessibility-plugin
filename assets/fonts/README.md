# Font Installation Guide

## OpenDyslexic Font

The OpenDyslexic font should be placed in this directory.

### Font File Path
The plugin expects the font file at:
```
assets/fonts/OpenDyslexic-Regular.ttf
```

This path is defined in the main plugin file:
- **PHP Constant**: `WP_ACCESSIBILITY_WIDGET_FONT_PATH`
- **CSS @font-face**: `url('../fonts/OpenDyslexic-Regular.ttf')`

### Download OpenDyslexic Font

1. Visit: https://opendyslexic.org/
2. Download the font package
3. Extract `OpenDyslexic-Regular.ttf` to this directory

### Alternative Fonts

If you want to use a different font, update the following files:
1. `wp-accessibility-widget.php` - Update the `WP_ACCESSIBILITY_WIDGET_FONT_PATH` constant
2. `assets/css/widget.css` - Update the `@font-face` src path
3. Place your custom font file in this directory

### License

OpenDyslexic is licensed under a Creative Commons Attribution 3.0 Unported License.
More info: https://opendyslexic.org/
