<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Domain\Model;

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

use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A blog
 */
class Blog extends AbstractEntity
{
    /**
     * @Extbase\Validate("FriendsOfTYPO3\BlogExample\Domain\Validator\TitleValidator")
     */
    protected string $title = '';
    /**
     * @Extbase\Validate("StringLength", options={"minimum": 5, "maximum": 80})
     */
    protected string|null $subtitle;

    /**
     * A short description of the blog
     *
     * @Extbase\Validate("StringLength", options={"maximum": 150})
     */
    protected string $description = '';

    /**
     * A relative path to a logo image
     */
    protected string $logo = '';

    /**
     * The posts of this blog
     *
     * @var ObjectStorage<Post>
     * @Extbase\ORM\Lazy
     * @Extbase\ORM\Cascade("remove")
     */
    protected $posts;

    /**
     * @var ObjectStorage<Category>
     */
    protected $categories;

    /**
     * The blog's administrator
     *
     * @var Administrator
     * @Extbase\ORM\Lazy
     */
    protected $administrator;

    /**
     * Constructs a new Blog
     */
    public function __construct()
    {
        $this->posts = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }

    /**
     * Adds a post to this blog
     */
    public function addPost(Post $post)
    {
        $this->posts->attach($post);
    }

    /**
     * Remove a post from this blog
     */
    public function removePost(Post $postToRemove)
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
     * Add category to a blog
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Set categories
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get categories
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Remove category from blog
     */
    public function removeCategory(Category $category)
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
