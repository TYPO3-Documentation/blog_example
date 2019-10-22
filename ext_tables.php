<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
/**
 * Registers a Backend Module
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'ExtbaseTeam.BlogExample',
    'web', // Make module a submodule of 'web'
    'tx_blogexample_m1', // Submodule key
    '', // Position
    [ // An array holding the controller-action-combinations that are accessible
        'Blog' => 'index,new,create,delete,deleteAll,edit,update,populate', // The first controller and its first action will be the default
        'Post' => 'index,show,new,create,delete,edit,update',
        'Comment' => 'create,delete,deleteAll',
    ],
    [
        'access' => 'user,group',
        'icon' => 'EXT:blog_example/ext_icon.gif',
        'labels' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_mod.xml',
    ]
);
/**
 * Add labels for context sensitive help (CSH)
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_BlogExampleTxBlogexampleM1', 'EXT:blog_example/Resources/Private/Language/locallang_csh.xml');

// Categorize Blog,Post records
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable('blog_example', 'tx_blogexample_domain_model_blog');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable('blog_example', 'tx_blogexample_domain_model_post');
