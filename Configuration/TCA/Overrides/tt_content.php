<?php

declare(strict_types=1);
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['itemGroups']['blog']
    = 'LLL:blog_example.db:group.blog';

/**
 * Registers a Plugin to be listed in the Backend.
 */
ExtensionUtility::registerPlugin(
    'blog_example',
    'BlogList',
    'LLL:blog_example.plugin:blog_list.title',
    'blog_example_icon',
    'blog_example',
    'LLL:blog_example.plugin:blog_list.description',
    'FILE:EXT:blog_example/Configuration/FlexForms/PluginSettings.xml',
);
ExtensionUtility::registerPlugin(
    'blog_example',
    'BlogAdmin',
    'LLL:blog_example.plugin:blog_admin.title',
    'blog_example_icon',
    'blog_example',
    'LLL:blog_example.plugin:blog_admin.description',
    'FILE:EXT:blog_example/Configuration/FlexForms/PluginSettings.xml',
);
