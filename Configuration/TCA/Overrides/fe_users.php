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

use T3docs\BlogExample\Domain\Model\Administrator;

defined('TYPO3') or die();

if (is_array($GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type'])) {
    $GLOBALS['TCA']['fe_users']['types'][Administrator::class] = $GLOBALS['TCA']['fe_users']['types']['0'];
    $GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type']['config']['items'][] = [
        'label' => 'LLL:EXT:blog_example/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.administrator',
        'value' => Administrator::class,
    ];
}
