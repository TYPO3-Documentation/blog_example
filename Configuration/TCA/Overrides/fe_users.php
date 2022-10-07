<?php
defined('TYPO3_MODE') or die();

if (is_array($GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type'])) {
    $GLOBALS['TCA']['fe_users']['types']['T3docs\BlogExample\Domain\Model\Administrator'] = $GLOBALS['TCA']['fe_users']['types']['0'];
    $GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type']['config']['items'][] = [
        'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.administrator',
        'T3docs\BlogExample\Domain\Model\Administrator',
    ];
}
