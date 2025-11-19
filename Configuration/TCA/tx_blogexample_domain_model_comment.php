<?php

return [
    'ctrl' => [
        'title' => 'LLL:blog_example.db:tx_blogexample_domain_model_comment',
        'label' => 'date',
        'label_alt' => 'author',
        'label_alt_force' => true,
        'origUid' => 't3_origuid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'blogexample_comment',
        ],
    ],
    'columns' => [
        'date' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_comment.date',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'datetime',
                'size' => 12,
                'eval' => 'datetime',
                'required' => true,
                'default' => time(),
            ],
        ],
        'author' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_comment.author',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'email' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_comment.email',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'content' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_comment.content',
            'config' => [
                'type' => 'text',
                'rows' => 30,
                'cols' => 80,
            ],
        ],
        'post' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, date, author, email, content, '],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];
