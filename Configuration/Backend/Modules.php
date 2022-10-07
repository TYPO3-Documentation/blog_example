<?php

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
