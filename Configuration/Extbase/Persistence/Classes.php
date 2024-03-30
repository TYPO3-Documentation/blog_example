<?php

declare(strict_types=1);

return [
    \T3docs\BlogExample\Domain\Model\Administrator::class => [
        'tableName' => 'fe_users',
        'recordType' => \T3docs\BlogExample\Domain\Model\Administrator::class,
        'properties' => [
            'administratorName' => [
                'fieldName' => 'username',
            ],
        ],
    ],
    \T3docs\BlogExample\Domain\Model\FrontendUserGroup::class => [
        'tableName' => 'fe_groups',
    ],
    \T3docs\BlogExample\Domain\Model\Blog::class => [
        'tableName' => 'tx_blogexample_domain_model_blog',
        'properties' => [
            'categories' => [
                'fieldName' => 'category',
            ],
        ],
    ],
    \T3docs\BlogExample\Domain\Model\Post::class => [
        'tableName' => 'tx_blogexample_domain_model_post',
        'properties' => [
            'categories' => [
                'fieldName' => 'category',
            ],
        ],
    ],
];
