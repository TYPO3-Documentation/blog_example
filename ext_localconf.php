<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
(static function (string $extensionName): void {
    /**
     * Configure the Plugin to call the
     * right combination of Controller and Action according to
     * the user input (default settings, FlexForm, URL etc.)
     */
    if (
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('blog_example', 'registerSinglePlugin')
    ) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extensionName,
            'Pi1',
            [
                \FriendsOfTYPO3\BlogExample\Controller\BlogController::class => 'index,new,create,delete,deleteAll,edit,update,populate',
                \FriendsOfTYPO3\BlogExample\Controller\PostController::class => 'index,show,new,create,delete,edit,update',
                \FriendsOfTYPO3\BlogExample\Controller\CommentController::class => 'create,delete',
            ],
            [
                \FriendsOfTYPO3\BlogExample\Controller\BlogController::class => 'create,delete,deleteAll,update,populate',
                \FriendsOfTYPO3\BlogExample\Controller\PostController::class => 'create,delete,update',
                \FriendsOfTYPO3\BlogExample\Controller\CommentController::class => 'create,delete',
            ]
        );
    } else {
        // Blog plugins
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extensionName,
            'BlogList',
            [\FriendsOfTYPO3\BlogExample\Controller\BlogController::class => 'index']
        );

        // Post plugins
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extensionName,
            'PostList',
            [\FriendsOfTYPO3\BlogExample\Controller\PostController::class => 'index']
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extensionName,
            'PostSingle',
            [\FriendsOfTYPO3\BlogExample\Controller\PostController::class => 'show', 'Comment' => 'create'],
            [\FriendsOfTYPO3\BlogExample\Controller\CommentController::class => 'create']
        );

        // admin plugins
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extensionName,
            'BlogAdmin',
            [
                \FriendsOfTYPO3\BlogExample\Controller\BlogController::class => 'new,create,delete,deleteAll,edit,update,populate',
                \FriendsOfTYPO3\BlogExample\Controller\PostController::class => 'new,create,delete,edit,update',
                \FriendsOfTYPO3\BlogExample\Controller\CommentController::class => 'delete',
            ],
            [
                \FriendsOfTYPO3\BlogExample\Controller\BlogController::class => 'create,delete,deleteAll,update,populate',
                \FriendsOfTYPO3\BlogExample\Controller\PostController::class => 'create,delete,update',
                \FriendsOfTYPO3\BlogExample\Controller\CommentController::class => 'delete',
            ]
        );
    }
})('BlogExample');
