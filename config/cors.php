<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://www.pialsoftdev.me'
    ],

    'allowed_origins_patterns' => [], // এটি খালি রাখুন যদি উপরে নির্দিষ্ট করে দেন

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];