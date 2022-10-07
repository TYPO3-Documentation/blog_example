<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
(static function (string $extensionKey): void {
    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'BlogExample',
        'web', // Make module a submodule of 'web'
        'tx_blogexample_m1', // Submodule key
        '', // Position
        [ // An array holding the controller-action-combinations that are accessible
            \T3docs\BlogExample\Controller\BlogController::class => 'index,new,create,delete,deleteAll,edit,update,populate', // The first controller and its first action will be the default
            \T3docs\BlogExample\Controller\PostController::class => 'index,show,new,create,delete,edit,update',
            \T3docs\BlogExample\Controller\CommentController::class => 'create,delete,deleteAll',
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:blog_example/Resources/Public/Icons/module-blog.svg',
            'labels' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_mod.xlf',
        ]
    );
    /**
     * Add labels for context sensitive help (CSH)
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_BlogExampleTxBlogexampleM1', 'EXT:blog_example/Resources/Private/Language/locallang_csh.xlf');

// Categorize Blog,Post records
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable($extensionKey, 'tx_blogexample_domain_model_blog');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable($extensionKey, 'tx_blogexample_domain_model_post');
})('blog_example');
