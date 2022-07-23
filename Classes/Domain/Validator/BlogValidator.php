<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Domain\Validator;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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

/**
 * An exemplary Blog validator
 */
class BlogValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        if (strtolower($value->getTitle()) === 'extbase') {
            $this->addError(LocalizationUtility::translate('error.Blog.invalidTitle',
                'BlogExample'), 1297418974);
        }
    }
}
