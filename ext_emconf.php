<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'A Blog Example for the Extbase Framework',
    'description' => 'This extension contains code examples used in TYPO3 explained to describe the use of Extbase',
    'version' => '13.0.0',
    'category' => 'example',
    'author' => 'TYPO3 Documentation Team and contributors',
    'author_company' => '',
    'author_email' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'T3docs\\BlogExample\\' => 'Classes/',
        ],
    ],
];
