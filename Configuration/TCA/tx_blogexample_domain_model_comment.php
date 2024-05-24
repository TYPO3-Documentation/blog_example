<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:tx_blogexample_domain_model_comment',
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
        'iconfile' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_comment.gif',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        't3ver_label' => [
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'none',
            ],
        ],
        'date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:tx_blogexample_domain_model_comment.date',
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
            'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:tx_blogexample_domain_model_comment.author',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'email' => [
            'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:tx_blogexample_domain_model_comment.email',
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
            'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:tx_blogexample_domain_model_comment.content',
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
        '1' => ['showitem' => 'hidden, date, author, email, content'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];
