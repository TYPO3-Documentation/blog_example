<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

use FriendsOfTYPO3\BlogExample\Controller\BlogController;
use FriendsOfTYPO3\BlogExample\Controller\PostController;
use FriendsOfTYPO3\BlogExample\Controller\CommentController;


(static function (string $extensionName): void {
    /**
     * Configure the Plugin to call the
     * right combination of Controller and Action according to
     * the user input (default settings, FlexForm, URL etc.)
     */
    if (
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('blog_example',
            'registerSinglePlugin')
    ) {
        ExtensionUtility::configurePlugin(
            $extensionName,
            'Pi1',
            [
                BlogController::class => 'index,new,create,delete,deleteAll,edit,update,populate',
                PostController::class => 'index,show,new,create,delete,edit,update',
                CommentController::class => 'create,delete',
            ],
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
            [BlogController::class => 'index']
        );

        // Post plugins
        ExtensionUtility::configurePlugin(
            $extensionName,
            'PostList',
            [PostController::class => 'index']
        );
        ExtensionUtility::configurePlugin(
            'BlogExample',
            'PostSingle',
            [PostController::class => 'show',CommentController::class => 'create'],
            [CommentController::class => 'create']
        );

        // admin plugins
        ExtensionUtility::configurePlugin(
            $extensionName,
            'BlogAdmin',
            [
                BlogController::class => 'new,create,delete,deleteAll,edit,update,populate',
                PostController::class => 'new,create,delete,edit,update',
                CommentController::class => 'delete',
            ],
            [
                BlogController::class => 'create,delete,deleteAll,update,populate',
                PostController::class => 'create,delete,update',
                CommentController::class => 'delete',
            ]
        );
    }

})('BlogExample');
