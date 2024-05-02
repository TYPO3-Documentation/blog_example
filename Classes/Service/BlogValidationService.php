<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Service;

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

use T3docs\BlogExample\Domain\Model\Blog;

class BlogValidationService
{
    private int $maxCategoryCount = 3;

    public function setMaxCategoryCount(int $maxCategoryCount): void
    {
        $this->maxCategoryCount = $maxCategoryCount;
    }

    public function isBlogCategoryCountValid(Blog $blog): bool
    {
        return $blog->getCategories()->count() <= $this->maxCategoryCount;
    }

    public function isBlogSubtitleValid(Blog $blog): bool
    {
        return strtolower($blog->getTitle()) !== strtolower($blog->subtitle ?? '');
    }
}
