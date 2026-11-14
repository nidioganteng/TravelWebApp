<?php

return [
    /*
     * Slides for the auth split-screen background.
     *
     * To add your own images, place .webp files (1920×1080, under 300 KB) in
     * public/img/auth/ and update the 'image' paths below.
     *
     * 'headline_key' and 'description_key' are translation keys resolved at
     * render time, so each language automatically gets the right text.
     *
     * Slides auto-advance every 6 seconds with a crossfade transition.
     * Auto-advance is paused when the browser tab is hidden and respects
     * prefers-reduced-motion.
     */
    'slides' => [
        [
            'image' => 'img/homepage/assets/background_hero.png',
            'headline_key' => 'user.auth_headline',
            'description_key' => 'user.auth_subheadline',
        ],
        [
            'image' => 'img/homepage/assets/tour_bali.jpg',
            'headline_key' => 'user.auth_headline_slide2',
            'description_key' => 'user.auth_subheadline_slide2',
        ],
        [
            'image' => 'img/homepage/assets/tour_vatican.jpg',
            'headline_key' => 'user.auth_headline_slide3',
            'description_key' => 'user.auth_subheadline_slide3',
        ],
    ],
];
