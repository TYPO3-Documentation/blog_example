<?php

declare(strict_types=1);

use T3docs\BlogExample\Domain\Model\Administrator;

defined('TYPO3') or die();

if (is_array($GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type'])) {
    $GLOBALS['TCA']['fe_users']['types'][Administrator::class] = $GLOBALS['TCA']['fe_users']['types']['0'];
    $GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type']['config']['items'][] = [
        'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.administrator',
        'value' => Administrator::class,
    ];
}
