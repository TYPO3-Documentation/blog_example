<?php

defined('TYPO3') or die();

use FriendsOfTYPO3\BlogExample\Controller\BlogController;
use FriendsOfTYPO3\BlogExample\Controller\CommentController;
use FriendsOfTYPO3\BlogExample\Controller\PostController;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

(static function (string $extensionName): void {
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
    // Only include page.tsconfig if TYPO3 version is below 12 so that it is not imported twice.
    if ($versionInformation->getMajorVersion() < 12) {
        ExtensionManagementUtility::addPageTSConfig('
      @import "EXT:blog_example/Configuration/page.tsconfig"
   ');
    }
    /**
     * Configure the Plugin to call the
     * right combination of Controller and Action according to
     * the user input (default settings, FlexForm, URL etc.)
     */
    if (
        GeneralUtility::makeInstance(ExtensionConfiguration::class)->get(
            'blog_example',
            'registerSinglePlugin'
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
            ]
        );
    } else {
        // Blog plugins
        ExtensionUtility::configurePlugin(
            $extensionName,
            'BlogList',
            // Cache-able Controller-Actions
            [
                BlogController::class => 'index',
            ]
        );

        // Post plugins
        ExtensionUtility::configurePlugin(
            $extensionName,
            'PostList',
            // Cache-able Controller-Actions
            [
                PostController::class => 'index',
            ]
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
            ]
        );

        // RSS Feed
        ExtensionUtility::configurePlugin(
            $extensionName,
            'PostListRss',
            // Cache-able Controller-Actions
            [
                PostController::class => 'displayRssList',
            ]
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
            ]
        );
    }
})('BlogExample');
