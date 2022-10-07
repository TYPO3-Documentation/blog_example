<?php

declare(strict_types = 1);

return [
    \TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class => [
        'subclasses' => [
            \T3docs\BlogExample\Domain\Model\Administrator::class => \T3docs\BlogExample\Domain\Model\Administrator::class
        ]
    ],
    \T3docs\BlogExample\Domain\Model\Administrator::class => [
        'tableName' => 'fe_users',
        'recordType' => \T3docs\BlogExample\Domain\Model\Administrator::class
    ],
];
