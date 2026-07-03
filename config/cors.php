<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://portfolio-and-blog-app-fontend.vercel.app',
        'http://localhost:5173',
    ],

    'allowed_origins_patterns' => [], // এটি খালি রাখুন যদি উপরে নির্দিষ্ট করে দেন

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];