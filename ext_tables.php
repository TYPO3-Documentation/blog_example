<?php
defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use T3docs\BlogExample\Controller\BlogController;
use T3docs\BlogExample\Controller\PostController;
use T3docs\BlogExample\Controller\CommentController;

(static function (string $extensionKey): void {
    /**
     * Registers a Backend Module
     */
    ExtensionUtility::registerModule(
        'BlogExample',
        'web', // Make module a submodule of 'web'
        'tx_blogexample_m1', // Submodule key
        '', // Position
        [ // An array holding the controller-action-combinations that are accessible
            BlogController::class => 'index,new,create,delete,deleteAll,edit,update,populate', // The first controller and its first action will be the default
            PostController::class => 'index,show,new,create,delete,edit,update',
            CommentController::class => 'create,delete,deleteAll',
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:blog_example/Resources/Public/Icons/module-blog.svg',
            'labels' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_mod.xlf',
        ]
    );

})('blog_example');
