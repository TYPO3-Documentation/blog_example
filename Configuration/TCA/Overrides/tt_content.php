<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

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

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blogexample_postlist']
    = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogexample_postlist']
    = 'pi_flexform,recursive';
ExtensionManagementUtility::addPiFlexFormValue(
    'blogexample_postlist',
    'FILE:EXT:blog_example/Configuration/FlexForms/PluginSettings.xml',
);
