<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'A Blog Example for the Extbase Framework',
    'description' => 'An example extension demonstrating the features of the Extbase Framework. Have fun playing with it!',
    'category' => 'example',
    'author' => 'TYPO3 Core Team',
    'author_company' => '',
    'author_email' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
