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

use T3docs\BlogExample\Controller\BackendController;

/**
 * Definitions for the backend module provided by EXT:blog_example
 */
return [
    'blog_example' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/page/blog_example',
        'labels' => 'LLL:EXT:blog_example/Resources/Private/Language/Module/locallang_mod.xlf',
        'extensionName' => 'BlogExample',
        'controllerActions' => [
            BackendController::class => [
                'index',
                'deleteAll',
                'populate',
                'showBlog',
                'showPost',
                'showAllComments',
            ],
        ],
    ],
];
