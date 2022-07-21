<?php
use FriendsOfTYPO3\BlogExample\Controller\BackendBlogController;
use FriendsOfTYPO3\BlogExample\Controller\BackendPostController;
use FriendsOfTYPO3\BlogExample\Controller\CommentController;
/**
 * Definitions for modules provided by EXT:examples
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
            BackendBlogController::class => [
                'index','deleteAll','populate',
            ],
            BackendPostController::class => [
                'index', 'show',
            ],
        ],
    ],
];
