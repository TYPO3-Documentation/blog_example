<?php

declare(strict_types=1);

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

use T3docs\BlogExample\Domain\Model\Administrator;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Model\FrontendUserGroup;
use T3docs\BlogExample\Domain\Model\Post;

return [
    Administrator::class => [
        'tableName' => 'fe_users',
        'recordType' => Administrator::class,
        'properties' => [
            'administratorName' => [
                'fieldName' => 'username',
            ],
        ],
    ],
    FrontendUserGroup::class => [
        'tableName' => 'fe_groups',
    ],
    Blog::class => [
        'tableName' => 'tx_blogexample_domain_model_blog',
        'properties' => [
            'categories' => [
                'fieldName' => 'category',
            ],
        ],
    ],
    Post::class => [
        'tableName' => 'tx_blogexample_domain_model_post',
        'properties' => [
            'categories' => [
                'fieldName' => 'category',
            ],
        ],
    ],
];
