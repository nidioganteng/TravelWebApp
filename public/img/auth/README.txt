Auth Background Images
======================

Images used in the auth split-screen layout (login, register, forgot/reset password)
are configured in config/auth_ui.php.

Currently the layout uses existing homepage images:
  - img/homepage/assets/background_hero.png  (slide 1)
  - img/homepage/assets/tour_bali.jpg         (slide 2)
  - img/homepage/assets/tour_vatican.jpg      (slide 3)

To add custom auth-specific images:
  1. Place .webp files here (1920x1080, under 300 KB recommended)
  2. Update the 'image' paths in config/auth_ui.php

To add or change translation text for each slide:
  - Edit 'headline_key' and 'description_key' in config/auth_ui.php
  - Add the matching keys to all lang/*.json files
    (en.json, id.json, nl.json, de.json, pt.json)

Slideshow behaviour:
  - Slides auto-advance every 6 seconds with a crossfade
  - Auto-advance pauses when the browser tab is hidden
  - Auto-advance is disabled for users with prefers-reduced-motion
  - Clicking a dot restarts the timer from that slide
