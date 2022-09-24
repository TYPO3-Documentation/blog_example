<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Service;

use FriendsOfTYPO3\BlogExample\Domain\Model\Post;

class PostValidationService
{
    private array $forbiddenTitles = [
        '77'
    ];

    public function isTitleValid(Post $post) {
        return !in_array($post->getTitle(), $this->forbiddenTitles);
    }
}
