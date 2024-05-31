<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Property\TypeConverters;

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
use TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException;
use TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;

class HiddenCommentConverter extends PersistentObjectConverter
{
    /**
     * @throws TargetNotFoundException
     * @throws InvalidSourceException
     */
    protected function fetchObjectFromPersistence(mixed $identity, string $targetType): Comment
    {
        if (ctype_digit((string)$identity)) {
            $query = $this->persistenceManager->createQueryForType($targetType);
            $query
                ->getQuerySettings()
                ->setRespectStoragePage(false)
                ->setIgnoreEnableFields(true)
                ->setEnableFieldsToBeIgnored(['disabled']);
            $object = $query->matching($query->equals('uid', $identity))->execute()->getFirst();
        } else {
            throw new InvalidSourceException(
                'The identity property "' . $identity . '" is no UID.',
                1641904861,
            );
        }

        if ($object === null) {
            throw new TargetNotFoundException(
                sprintf('Object of type %s with identity "%s" not found.', $targetType, print_r($identity, true)),
                1641904896,
            );
        }

        return $object;
    }
}
