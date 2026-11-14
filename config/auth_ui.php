<?php

return [
    /*
     * Slides for the auth split-screen background.
     *
     * Images live in public/img/auth/ — see the README.txt there for specs.
     * 'headline_key' and 'description_key' are translation keys resolved at
     * render time, so each language automatically gets the right text.
     *
     * Slides auto-advance every 6 seconds with a crossfade transition.
     * Auto-advance is paused when the browser tab is hidden and respects
     * prefers-reduced-motion.
     */
    'slides' => [
        [
            'image' => 'img/auth/tampilng.png',
            'headline_key' => 'user.auth_headline',
            'description_key' => 'user.auth_subheadline',
        ],
    ],
];
