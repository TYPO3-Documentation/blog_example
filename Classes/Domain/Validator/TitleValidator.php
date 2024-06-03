<?php

namespace T3docs\BlogExample\Domain\Validator;

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

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

final class TitleValidator extends AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        // $value is the title string
        if (is_scalar($value) && str_starts_with((string)$value, '_')) {
            $errorString = 'The title may not start with an underscore. ';
            $this->addError($errorString, 1297418976);
        }
    }
}
