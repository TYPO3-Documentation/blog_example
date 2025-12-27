<?php

namespace T3docs\BlogExample\Upgrades;

use TYPO3\CMS\Core\Attribute\UpgradeWizard;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[UpgradeWizard('blogExample_migratePluginsToContentElementsUpgradeWizard')]
final readonly class MigratePluginsToContentElementsUpgradeWizard implements UpgradeWizardInterface
{
    private const PLUGINS = [
        'blogexample_bloglist',
        'blogexample_blogadmin',
        'blogexample_postlistrss',
    ];
    public function __construct(private ConnectionPool $connectionPool) {}

    public function getTitle(): string
    {
        return 'Migrate plugins to Content Elements';
    }

    public function getDescription(): string
    {
        return 'The modern way to register plugins for TYPO3 is to register them as content element types. ' .
            'Running this wizard will migrate all blog_example plugins to content element (CType)';
    }

    public function executeUpdate(): bool
    {
        foreach (self::PLUGINS as $pluginName) {
            $queryBuilder = $this->getQueryBuilder();

            $queryBuilder
                ->update('tt_content')
                ->set('CType', $pluginName)
                ->set('list_type', '')
                ->where(
                    $queryBuilder->expr()->eq(
                        'CType',
                        $queryBuilder->createNamedParameter('list'),
                    ),
                    $queryBuilder->expr()->eq(
                        'list_type',
                        $queryBuilder->createNamedParameter($pluginName),
                    ),
                )
                ->executeStatement();
        }

        return true;
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = $this->getQueryBuilder();

        $orConstraints = [];
        foreach (self::PLUGINS as $pluginName) {
            $orConstraints[] = $queryBuilder->expr()->eq(
                'list_type',
                $queryBuilder->createNamedParameter($pluginName),
            );
        }

        return (bool)$queryBuilder
            ->count('*')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'CType',
                    $queryBuilder->createNamedParameter('list'),
                ),
                $queryBuilder->expr()->or(...$orConstraints),
            )
            ->executeQuery()
            ->fetchOne();
    }

    private function getQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');

        $queryBuilder
            ->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder;
    }

    public function getPrerequisites(): array
    {
        return [];
    }
}
