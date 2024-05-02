<?php

defined('TYPO3') or die();

use T3docs\BlogExample\Controller\BlogController;
use T3docs\BlogExample\Controller\CommentController;
use T3docs\BlogExample\Controller\PostController;

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

(static function (string $extensionName): void {
    // Blog plugins
    ExtensionUtility::configurePlugin(
        $extensionName,
        'BlogList',
        // Cache-able Controller-Actions
        [
            BlogController::class => 'index',
            PostController::class => 'index, show',
            CommentController::class => 'create',
        ],
        [
            CommentController::class => 'create',
        ],
    );

    // RSS Feed
    ExtensionUtility::configurePlugin(
        $extensionName,
        'PostListRss',
        // Cache-able Controller-Actions
        [
            PostController::class => 'displayRssList',
        ],
    );

    // admin plugins
    ExtensionUtility::configurePlugin(
        $extensionName,
        'BlogAdmin',
        // Cache-able Controller-Actions
        [
            BlogController::class => 'new,create,delete,deleteAll,edit,update,populate',
            PostController::class => 'new,create,delete,edit,update',
            CommentController::class => 'delete',
        ],
        // Non-Cache-able Controller-Actions
        [
            BlogController::class => 'create,delete,deleteAll,update,populate',
            PostController::class => 'create,delete,update',
            CommentController::class => 'delete',
        ],
    );
})('BlogExample');
