<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

/**
 * Configure the Plugin to call the
 * right combination of Controller and Action according to
 * the user input (default settings, FlexForm, URL etc.)
 */
if (
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('blog_example', 'registerSinglePlugin')
) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ExtbaseTeam.BlogExample',
        'Pi1',
        [
            'Blog' => 'index,new,create,delete,deleteAll,edit,update,populate',
            'Post' => 'index,show,new,create,delete,edit,update',
            'Comment' => 'create,delete',
        ],
        [
            'Blog' => 'create,delete,deleteAll,update,populate',
            'Post' => 'create,delete,update',
            'Comment' => 'create,delete',
        ]
    );
} else {

    // Blog plugins
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ExtbaseTeam.BlogExample',
        'BlogList',
        ['Blog' => 'index']
    );

    // Post plugins
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ExtbaseTeam.BlogExample',
        'PostList',
        ['Post' => 'index']
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ExtbaseTeam.BlogExample',
        'PostSingle',
        ['Post' => 'show', 'Comment' => 'create'],
        ['Comment' => 'create']
    );

    // admin plugins
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ExtbaseTeam.BlogExample',
        'BlogAdmin',
        [
            'Blog' => 'new,create,delete,deleteAll,edit,update,populate',
            'Post' => 'new,create,delete,edit,update',
            'Comment' => 'delete',
        ],
        [
            'Blog' => 'create,delete,deleteAll,update,populate',
            'Post' => 'create,delete,update',
            'Comment' => 'delete',
        ]
    );
}
