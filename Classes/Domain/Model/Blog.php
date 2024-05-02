<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

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

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A blog
 */
class Blog extends AbstractEntity
{
    #[Validate(['validator' => '\T3docs\BlogExample\Domain\Validator\TitleValidator'])]
    public string $title = '';

    #[Validate(['validator' => 'StringLength', 'options' => ['minimum' => 5, 'maximum' => 80]])]
    public string|null $subtitle;

    /**
     * A short description of the blog
     */
    #[Validate(['validator' => 'StringLength', 'options' => ['maximum' => 150]])]
    public string $description = '';

    /**
     * A relative path to a logo image
     */
    public string $logo = '';

    /**
     * The posts of this blog
     * @var ObjectStorage<Post>
     */
    #[Extbase\ORM\Lazy()]
    #[Cascade(['value' => 'remove'])]
    public $posts;

    /**
     * @var ?ObjectStorage<Category>
     */
    public ?ObjectStorage $categories = null;

    /**
     * The blog's administrator
     * @var Administrator
     */
    #[Extbase\ORM\Lazy()]
    public $administrator;

    public function __construct()
    {
        $this->posts = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }

    /**
     * Adds a post to this blog
     */
    public function addPost(Post $post): void
    {
        $this->posts->attach($post);
    }

    /**
     * Remove a post from this blog
     */
    public function removePost(Post $postToRemove): void
    {
        $this->posts->detach($postToRemove);
    }

    /**
     * Remove all posts from this blog
     */
    public function removeAllPosts(): void
    {
        $this->posts = new ObjectStorage();
    }

    /**
     * Returns all posts in this blog
     *
     * @return ObjectStorage
     */
    public function getPosts(): ObjectStorage
    {
        return $this->posts;
    }

    /**
     * @param ObjectStorage<Post> $posts
     */
    public function setPosts(ObjectStorage $posts): void
    {
        $this->posts = $posts;
    }

    /**
     * Add category to a blog
     *
     * @param Category $category
     */
    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    /**
     * Set categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Get categories
     */
    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Remove category from blog
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
