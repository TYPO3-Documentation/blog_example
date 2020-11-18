<?php

declare(strict_types = 1);

return [
    \TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class => [
        'subclasses' => [
            \FriendsOfTYPO3\BlogExample\Domain\Model\Administrator::class => \FriendsOfTYPO3\BlogExample\Domain\Model\Administrator::class
        ]
    ],
    \FriendsOfTYPO3\BlogExample\Domain\Model\Administrator::class => [
        'tableName' => 'fe_users',
        'recordType' => \FriendsOfTYPO3\BlogExample\Domain\Model\Administrator::class
    ],
];
