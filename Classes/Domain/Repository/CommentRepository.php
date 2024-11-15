<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Repository;

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

use T3docs\BlogExample\Domain\Model\Comment;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @extends Repository<Comment>
 */
class CommentRepository extends Repository
{
    protected $defaultOrderings = ['date' => QueryInterface::ORDER_DESCENDING];

    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        // Show comments from all pages
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return QueryResultInterface<int, Comment>
     */
    public function findAllIgnoreEnableFields(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        return $query->execute();
    }
}
