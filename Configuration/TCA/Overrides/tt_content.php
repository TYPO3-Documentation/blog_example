<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['itemGroups']['blog']
    = 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:group.blog';

/**
 * Registers a Plugin to be listed in the Backend.
 */
$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
ExtensionUtility::registerPlugin(
    'blog_example',
    'BlogList',
    'List of Blogs (BlogExample)',
    'blog_example_icon',
);
ExtensionUtility::registerPlugin(
    'blog_example',
    'BlogAdmin',
    'Admin Plugin (BlogExample)',
    'blog_example_icon',
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blogexample_bloglist']
    = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogexample_bloglist']
    = 'pi_flexform,recursive';
ExtensionManagementUtility::addPiFlexFormValue(
    'blogexample_bloglist',
    'FILE:EXT:blog_example/Configuration/FlexForms/PluginSettings.xml',
);
