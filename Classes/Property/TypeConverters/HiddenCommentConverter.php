<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Property\TypeConverters;

use FriendsOfTYPO3\BlogExample\Domain\Model\Comment;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;
use TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException;
use TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException;

class HiddenCommentConverter extends PersistentObjectConverter
{

    /**
     * @param mixed $identity
     * @param string $targetType
     * @throws TargetNotFoundException
     * @throws InvalidSourceException
     * @return Comment
     */
    protected function fetchObjectFromPersistence($identity, string $targetType): object
    {
        if (ctype_digit((string)$identity)) {
            $query = $this->persistenceManager->createQueryForType($targetType);
            $query->getQuerySettings()->setIgnoreEnableFields(true);
            $object = $query->matching($query->equals('uid', $identity))->execute()->getFirst();
        } else {
            throw new InvalidSourceException(
                'The identity property "' . $identity . '" is no UID.',
                1641904861
            );
        }

        if ($object === null) {
            throw new TargetNotFoundException(
                sprintf('Object of type %s with identity "%s" not found.', $targetType, print_r($identity, true)),
                1641904896
            );
        }

        return $object;
    }
}
