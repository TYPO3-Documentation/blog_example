<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Validator;

use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Service\BlogValidationService;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

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
final class BlogValidator extends AbstractValidator
{
    public function __construct(
        private readonly BlogValidationService $blogValidationService,
    ) {
        parent::__construct();
    }

    /**
     * Checks whether the given blog is valid
     *
     * @param Blog $blog The blog
     */
    protected function isValid(mixed $value): void
    {
        if (!$value instanceof Blog) {
            $errorString = 'The blog validator can only handle classes '
                . 'of type T3docs\BlogExample\Domain\Validator\Blog. '
                . $value::class . ' given instead.';
            $this->addError($errorString, 1297418975);
        }
        if (!$this->blogValidationService->isBlogCategoryCountValid($value)) {
            $errorString = LocalizationUtility::translate(
                'error.Blog.tooManyCategories',
                'BlogExample',
            );
            // Add the error to the property if it is specific to one property
            $this->addErrorForProperty('categories', $errorString, 1297418976);
        }
        if (!$this->blogValidationService->isBlogSubtitleValid($value)) {
            $errorString = LocalizationUtility::translate(
                'error.Blog.invalidSubTitle',
                'BlogExample',
            );
            // Add the error directly if it takes several properties into account
            $this->addError($errorString, 1297418974);
        }
    }
}
