<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Service;

use FriendsOfTYPO3\BlogExample\Domain\Model\Blog;

class BlogValidationService
{
    private int $maxCategoryCount = 3;

    public function setMaxCategoryCount(int $maxCategoryCount): void
    {
        $this->maxCategoryCount = $maxCategoryCount;
    }

    public function isBlogCategoryCountValid(Blog $blog)
    {
        return $blog->getCategories()->count() <= $this->maxCategoryCount;
    }

    public function isBlogSubtitleValid(Blog $blog)
    {
        return strtolower($blog->getTitle()) !== strtolower($blog->getSubtitle());
    }
}
