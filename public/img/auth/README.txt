Auth Background Images
======================

Place your slide images here. They are referenced from config/auth_ui.php.

Recommended format:
  - Format  : WebP
  - Size    : 1920 × 1080 px
  - File size: under 300 KB
  - Example : slide1.webp, slide2.webp

After adding images, update config/auth_ui.php:

    'slides' => [
        [
            'image'           => 'img/auth/slide1.webp',
            'headline_key'    => 'user.auth_headline',
            'description_key' => 'user.auth_subheadline',
        ],
        // add more slides here ...
    ],

If slides > 1, the left panel rotates automatically every 6 seconds with a
fade transition. Dots appear and are clickable. If slides = 1, dots are hidden.
