<?php

declare(strict_types=1);

use T3docs\BlogExample\ExpressionLanguage\ExtensionConfigurationProvider;

defined('TYPO3') or die();

return [
    'typoscript' => [
        ExtensionConfigurationProvider::class,
    ],
];
