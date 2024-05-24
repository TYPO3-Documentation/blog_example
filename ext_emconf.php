<?php

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

$EM_CONF[$_EXTKEY] = [
    'title' => 'A Blog Example for the Extbase Framework',
    'description' => 'This extension contains code examples used in TYPO3 explained to describe the use of Extbase',
    'version' => '13.0.0',
    'category' => 'example',
    'author' => 'TYPO3 Documentation Team and contributors',
    'author_company' => '',
    'author_email' => '',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '13.1.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'T3docs\\BlogExample\\' => 'Classes/',
        ],
    ],
];
