<?php

declare(strict_types=1);

namespace T3docs\BlogExample\ExpressionLanguage;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtensionConfigurationProvider extends AbstractProvider
{
    public function __construct()
    {
        $configuration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->expressionLanguageVariables = [
            'blogConfiguration' => $configuration->get('blog_example'),
        ];
    }
}
