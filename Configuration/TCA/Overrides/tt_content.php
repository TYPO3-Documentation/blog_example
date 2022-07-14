<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

/**
 * Registers a Plugin to be listed in the Backend.
 */
$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
if ($extensionConfiguration->get('blog_example', 'registerSinglePlugin')) {
    ExtensionUtility::registerPlugin(
        'blog_example',
        'Pi1',
        'A Blog Example' // A title shown in the backend dropdown field
    );
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blogexample_pi1']
        = 'select_key';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogexample_pi1']
        = 'pi_flexform,recursive';
    ExtensionManagementUtility::addPiFlexFormValue(
        'blogexample_pi1',
        'FILE:EXT:blog_example/Configuration/FlexForms/flexform_list.xml');
} else {
    ExtensionUtility::registerPlugin(
        'blog_example',
        'BlogList',
        'List of Blogs (BlogExample)',
        'blog_example_icon'
    );
    ExtensionUtility::registerPlugin(
        'blog_example',
        'PostList',
        'List of Posts (BlogExample)',
        'blog_example_icon'
    );
    ExtensionUtility::registerPlugin(
        'blog_example',
        'PostSingle',
        'Single Post (BlogExample)',
        'blog_example_icon'
    );
    ExtensionUtility::registerPlugin(
        'blog_example',
        'BlogAdmin',
        'Admin Plugin (BlogExample)',
        'blog_example_icon'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blogexample_postlist']
        = 'select_key';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogexample_postlist']
        = 'pi_flexform,recursive';
    ExtensionManagementUtility::addPiFlexFormValue(
        'blogexample_postlist',
        'FILE:EXT:blog_example/Configuration/FlexForms/flexform_list.xml'
    );
}
