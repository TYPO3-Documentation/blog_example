<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'A Blog Example for the Extbase Framework',
    'description' => 'An example extension demonstrating the features of the Extbase Framework. Have fun playing with it!',
    'version' => '11.0.0',
    'category' => 'example',
    'author' => 'TYPO3 Documentation Team and Contributors',
    'author_company' => '',
    'author_email' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'T3docs\\BlogExample\\' => 'Classes'
        ]
    ],
];
