<?php

return [
    'ctrl' => [
        'title' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'fe_group' => 'fe_group',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'blogexample_blog',
        ],
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.title',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'subtitle' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'required' => true,
            ],
        ],
        'logo' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.logo',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:frontend:ttc:images.addFileReference',
                ],
            ],
        ],
        'posts' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.posts',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_blogexample_domain_model_post',
                'foreign_field' => 'blog',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
        'administrator' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.administrator',
            'description' => 'LLL:blog_example.db:tx_blogexample_domain_model_blog.administrator.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_table_where' => "AND fe_users.tx_extbase_type='T3docs\\\\BlogExample\\\\Domain\\\\Model\\\\Administrator'",
                'items' => [
                    ['label' => '--none--', 'value' => 0],
                ],
                'default' => 0,
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
        'category' => [
            'config' => [
                'type' => 'category',
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
            --div--;LLL:core.form.tabs:general,
                title, description, logo,
            --div--;LLL:blog_example.db:tx_blogexample_domain_model_blog.posts,
                posts,
            --div--;LLL:core.form.tabs:categories,
                    category,
            --div--;LLL:core.form.tabs:access,
                administrator,
                --palette--;;paletteHidden,
                --palette--;;paletteAccess,
            --div--;LLL:core.form.tabs:language,
                --palette--;;paletteLanguage,
            --div--;LLL:core.form.tabs:extended,
        '],
    ],
    'palettes' => [
        'paletteHidden' => [
            'showitem' => 'hidden',
        ],
        'paletteAccess' => [
            'showitem' => '
                starttime, endtime,
                --linebreak--,
                fe_group',
        ],
        'paletteLanguage' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
    ],
];
