<?php

declare(strict_types=1);
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['itemGroups']['blog']
    = 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:group.blog';

/**
 * Registers a Plugin to be listed in the Backend.
 */
ExtensionUtility::registerPlugin(
    'blog_example',
    'BlogList',
    'List of Blogs (BlogExample)',
    'blog_example_icon',
    'plugins',
    'Display a list of blogs',
);
ExtensionUtility::registerPlugin(
    'blog_example',
    'BlogAdmin',
    'Admin Plugin (BlogExample)',
    'blog_example_icon',
    'plugins',
    'Administrate the blog',
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Configuration,pi_flexform',
    'blogexample_bloglist',
    'after:subheader',
);

ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:blog_example/Configuration/FlexForms/PluginSettings.xml',
    'blogexample_bloglist',
);
