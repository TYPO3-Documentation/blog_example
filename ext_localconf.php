<?php

defined('TYPO3') or die();

use T3docs\BlogExample\Controller\BlogController;
use T3docs\BlogExample\Controller\CommentController;
use T3docs\BlogExample\Controller\PostController;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

(static function (string $extensionName): void {
    /**
     * Configure the Plugin to call the
     * right combination of Controller and Action according to
     * the user input (default settings, FlexForm, URL etc.)
     */
    if (
        GeneralUtility::makeInstance(ExtensionConfiguration::class)->get(
            'blog_example',
            'registerSinglePlugin',
        )
    ) {
        ExtensionUtility::configurePlugin(
            $extensionName,
            'Pi1',
            // Cache-able Controller-Actions
            [
                BlogController::class => 'index,new,create,delete,deleteAll,edit,update,populate',
                PostController::class => 'index,show,new,create,delete,edit,update',
                CommentController::class => 'create,delete',
            ],
            // Non-Cache-able Controller-Actions
            [
                BlogController::class => 'create,delete,deleteAll,update,populate',
                PostController::class => 'create,delete,update',
                CommentController::class => 'create,delete',
            ],
        );
    } else {
        // Blog plugins
        ExtensionUtility::configurePlugin(
            $extensionName,
            'BlogList',
            // Cache-able Controller-Actions
            [
                BlogController::class => 'index',
            ],
        );

        // Post plugins
        ExtensionUtility::configurePlugin(
            $extensionName,
            'PostList',
            // Cache-able Controller-Actions
            [
                PostController::class => 'index',
            ],
        );
        ExtensionUtility::configurePlugin(
            'BlogExample',
            'PostSingle',
            // Cache-able Controller-Actions
            [
                PostController::class => 'show',
                CommentController::class => 'create',
            ],
            // Non-Cache-able Controller-Actions
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
    }
})('BlogExample');
