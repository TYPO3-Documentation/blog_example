<?php

namespace FriendsOfTYPO3\BlogExample\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

final class TitleValidator extends AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        // $value is the title string
        if (str_starts_with('_', $value)) {
            $errorString = 'The title may not start with an underscore. ';
            $this->addError($errorString, 1297418976);
        }
    }
}
