<?php
declare(strict_types = 1);
defined('TYPO3') or die();

/**
 * Registers a Plugin to be listed in the Backend.
 */
if (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)
    ->get('blog_example', 'registerSinglePlugin')) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'blog_example',
        'Pi1',
        'A Blog Example' // A title shown in the backend dropdown field
    );
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blogexample_pi1'] = 'select_key';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogexample_pi1'] = 'pi_flexform,recursive';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('blogexample_pi1', 'FILE:EXT:' . 'blog_example' . '/Configuration/FlexForms/flexform_list.xml');
} else {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'blog_example',
        'BlogList',
        'List of Blogs (BlogExample)'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'blog_example',
        'PostList',
        'List of Posts (BlogExample)'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'blog_example',
        'PostSingle',
        'Single Post (BlogExample)'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'blog_example',
        'BlogAdmin',
        'Admin Plugin (BlogExample)'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blogexample_postlist'] = 'select_key';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogexample_postlist'] = 'pi_flexform,recursive';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('blogexample_postlist', 'FILE:EXT:' . 'blog_example' . '/Configuration/FlexForms/flexform_list.xml');
}
