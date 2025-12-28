<?php

return [
    'ctrl' => [
        'title' => 'LLL:blog_example.db:tx_blogexample_domain_model_post',
        'label' => 'title',
        'label_alt' => 'author',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'blogexample_post',
        ],
    ],
    'columns' => [
        'blog' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.blog',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_blogexample_domain_model_blog',
                'maxitems' => 1,
            ],
        ],
        'title' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.title',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'date' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.date',
            'config' => [
                'type' => 'datetime',
                'eval' => 'datetime',
            ],
        ],
        'author' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.author',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_blogexample_domain_model_person',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'setValue' => 'prepend',
                        ],
                    ],
                ],
            ],
        ],
        'second_author' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.second_author',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_blogexample_domain_model_person',
                'foreign_table' => 'tx_blogexample_domain_model_person',
                'maxitems' => 1,
                'default' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'reviewer' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.reviewer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_blogexample_domain_model_person',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'setValue' => 'prepend',
                        ],
                    ],
                ],
            ],
        ],
        'content' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.content',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.tags',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_blogexample_domain_model_tag',
                'MM' => 'tx_blogexample_post_tag_mm',
                'appearance' => [
                    'useCombination' => 1,
                    'useSortable' => 1,
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
        'comments' => [
            'exclude' => true,
            'label' => 'Comments',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_blogexample_domain_model_comment',
                'foreign_table' => 'tx_blogexample_domain_model_comment',
                'foreign_field' => 'post',
                'foreign_table_where' => 'ORDER BY tx_blogexample_domain_model_comment.uid',
                'size' => 10,
                'maxitems' => 9999,
                'minitems' => 0,
                'default' => '',
            ],
        ],
        'related_posts' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.related',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'size' => 10,
                'autoSizeMax' => 30,
                'multiple' => 0,
                'foreign_table' => 'tx_blogexample_domain_model_post',
                'foreign_table_where' => 'AND ###THIS_UID### != tx_blogexample_domain_model_post.uid',
                'MM' => 'tx_blogexample_post_post_mm',
                // @see https://forge.typo3.org/issues/98323
                // 'MM_opposite_field' => 'related_posts',
            ],
        ],
        'additional_name' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.additional_name',
            'config' => [
                'type' => 'inline', // this will store the info uid in the additional_name field (CSV)
                'foreign_table' => 'tx_blogexample_domain_model_info',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'additional_info' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_post.additional_info',
            'config' => [
                'type' => 'inline', // this will store the post uid in the post field of the info table
                'foreign_table' => 'tx_blogexample_domain_model_info',
                'foreign_field' => 'post',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'category' => [
            'config' => [
                'type' => 'category',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
                --div--;LLL:core.form.tabs:general,
                    blog, title, date, author, second_author, content, tags, comments, related_posts, additional_name, additional_info,
                --div--;LLL:core.form.tabs:categories,
                    category,
                --div--;LLL:core.form.tabs:access,
                    hidden,
                --div--;LLL:core.form.tabs:language,
                    --palette--;;paletteLanguage,
                --div--;LLL:core.form.tabs:extended,
        '],
    ],
    'palettes' => [
        'paletteLanguage' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
    ],
];
