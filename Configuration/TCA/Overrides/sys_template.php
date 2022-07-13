<?php
declare(strict_types = 1);
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
defined('TYPO3') or die();

ExtensionManagementUtility::addStaticFile('blog_example', 'Configuration/TypoScript', 'BlogExample setup');
ExtensionManagementUtility::addStaticFile('blog_example', 'Configuration/TypoScript/DefaultStyles', 'BlogExample CSS Styles (optional)');
