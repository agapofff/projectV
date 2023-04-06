<?php

return [
    'post' => [
        'type' => 1,
        'description' => 'Post',
        'ruleName' => 'group',
    ],
    'seo' => [
        'type' => 1,
        'description' => 'SEO',
        'ruleName' => 'group',
    ],
    'translator' => [
        'type' => 1,
        'description' => 'Translator',
        'ruleName' => 'group',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'ruleName' => 'group',
        'children' => [
            'post',
            'seo',
            'translator',
        ],
    ],
];
