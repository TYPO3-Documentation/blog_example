<?php

return [
    'ctrl' => [
        'title' => 'LLL:blog_example.db:tx_blogexample_domain_model_person',
        'label' => 'lastname',
        'label_alt' => 'firstname',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
        'origUid' => 't3_origuid',
        'prependAtCopy' => 'LLL:core.general.xlf:LGL.prependAtCopy',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:blog_example/Resources/Public/Icons/icon_tx_blogexample_domain_model_person.gif',
    ],
    'columns' => [
        'firstname' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_person.firstname',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'lastname' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_person.lastname',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'email' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_person.email',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'tags' => [
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_person.tags',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_blogexample_domain_model_tag', // needed by Extbase
                'MM' => 'tx_blogexample_domain_model_tag_mm',
                'MM_match_fields' => [
                    'fieldname' => 'tags',
                ],
                'appearance' => [
                    'useCombination' => 1,
                    'useSortable' => 1,
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
        'tags_special' => [
            'exclude' => true,
            'label' => 'LLL:blog_example.db:tx_blogexample_domain_model_person.tags_special',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_blogexample_domain_model_tag', // needed by Extbase
                'MM' => 'tx_blogexample_domain_model_tag_mm',
                'MM_match_fields' => [
                    'fieldname' => 'tags_special',
                ],
                'appearance' => [
                    'useCombination' => 1,
                    'useSortable' => 1,
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
                --div--;LLL:core.form.tabs:general,
                    firstname, lastname, email, avatar, tags, tags_special,
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
