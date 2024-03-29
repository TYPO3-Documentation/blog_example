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
];
