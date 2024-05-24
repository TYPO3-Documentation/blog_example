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

namespace T3docs\BlogExample\Upgrades;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('blogExample_pluginUpgradeWizard')]
final class PluginUpgradeWizard implements UpgradeWizardInterface
{
    private const OLD_LIST_TYPE = 'blogexample_pi1';
    private const NEW_LIST_TYPE = 'blogexample_bloglist';
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function getTitle(): string
    {
        return 'Rename outdated plugins';
    }

    public function getDescription(): string
    {
        return '';
    }

    public function executeUpdate(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $result = $queryBuilder
            ->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('list_type', $queryBuilder->createNamedParameter(self::OLD_LIST_TYPE)),
            )
            ->set('list_type', self::NEW_LIST_TYPE)
            ->executeStatement();
        return $result > 0;
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $count = $queryBuilder
            ->count('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('list_type', $queryBuilder->createNamedParameter(self::OLD_LIST_TYPE)),
            )
            ->executeQuery()
            ->fetchOne();
        return is_int($count) && $count > 0;
    }

    public function getPrerequisites(): array
    {
        return [];
    }
}
