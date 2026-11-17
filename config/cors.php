<?php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    // Comma separated list, e.g. FRONTEND_URL=http://localhost:5173,https://yourdomain.com
    'allowed_origins' => array_values(array_filter(array_map('trim', explode(',', env('FRONTEND_URL', 'http://localhost:5173'))))),
    'allowed_origins_patterns' => [
        '#^https://.*\.vercel\.app$#',
    ],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // সেশন বা কুকি হ্যান্ডেল করার জন্য true করে দেওয়া ভালো
];
