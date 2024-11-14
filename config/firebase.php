<?php

return [
    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase/firebase-credentials.json')),
    ],

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL'),
    ],

    'dynamic_links' => [
        'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN')
    ],

    'project_id' => env('FIREBASE_PROJECT_ID'),

    'storage' => [
        'default_bucket' => env('FIREBASE_STORAGE_BUCKET')
    ],

    'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

    'logging' => [
        'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL', null),
        'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL', null),
    ],

    'authentication' => [
        'tenant_id' => env('FIREBASE_AUTH_TENANT_ID', null),
    ],
];