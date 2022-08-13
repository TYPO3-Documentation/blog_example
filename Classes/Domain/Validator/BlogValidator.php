<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Domain\Validator;

use FriendsOfTYPO3\BlogExample\Domain\Model\Blog;
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
class BlogValidator extends AbstractValidator
{

    /**
     * Checks whether the given blog is valid
     *
     * @param Blog $blog The blog
     */
    public function isValid($blog): bool
    {
        if (strtolower($blog->getTitle()) === 'extbase') {
            $this->addError(LocalizationUtility::translate('error.Blog.invalidTitle', 'BlogExample'), 1297418974);
            return false;
        }
        return true;
    }

}
