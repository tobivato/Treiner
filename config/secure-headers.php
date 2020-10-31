<?php

return [
    // Safe Mode
    'safeMode' => true,

    // HSTS Strict-Transport-Security
    'hsts' => [
        'enabled' => env('HSTS_ENABLED', true),
    ],

    // Content Security Policy
    'csp' => [
        'default' => 'self',
        'form-action' => [
            'self',
            '*.facebook.com',
        ],
        'img-src' => [
            '*', // Allow images from anywhere
            'data:',
        ],
        'script-src' => [
            'self',
            'unsafe-inline',
            '*.algolia.net',
            '*.algolianet.com',
            '*.youtube.com',
            '*.stripe.com',
            '*.doubleclick.net',
            '*.googleapis.com',
            '*.segment.com',
            '*.redditstatic.com',
            '*.google-analytics.com',
            '*.facebook.net',
            '*.bootstrapcdn.com',
            '*.jsdelivr.net',
            'https://zoom.us',
            'blob:',
        ],
        'connect-src' => [
            'self',
            '*.algolia.net',
            '*.algolianet.com',
            '*.segment.io',
            '*.zoom.us',
            'wss:',
        ],
        'frame-src' => [
            'self',
            '*.youtube.com',
            '*.stripe.com',
            '*.facebook.com'
        ],
        'style-src' => [
            'self',
            'unsafe-inline', // Allow inline styles
            '*.googleapis.com', // Allow stylesheets from Google Fonts
            '*.bootstrapcdn.com',
        ],
        'font-src' => [
            'self',
            'data:',
            '*.bootstrapcdn.com',
            '*.googleapis.com',
            '*.gstatic.com', // Allow fonts from the Google Fonts CDN
        ],
    ],
];