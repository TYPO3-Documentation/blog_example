<?php

declare(strict_types=1);

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

namespace T3docs\BlogExample\Tests\Unit\Domain\Model;

use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Model\Post;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BlogTest extends UnitTestCase
{
    protected Blog $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Blog();
    }

    public function testGetTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitle(),
        );
    }

    public function testSetTitleSetsTitle(): void
    {
        $this->subject->setTitle('TYPO3');

        self::assertSame(
            'TYPO3',
            $this->subject->getTitle(),
        );
    }

    public function testSubtitleWillInitiallyReturnNull(): void
    {
        self::assertNull(
            $this->subject->subtitle,
        );
    }

    public function testDescriptionWillInitiallyReturnEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->description,
        );
    }

    public function testLogoWillInitiallyReturnEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->logo,
        );
    }

    public function testPostWillInitiallyReturnEmptyObjectStorage(): void
    {
        $posts = $this->subject->getPosts();

        self::assertInstanceOf(
            ObjectStorage::class,
            $posts,
        );

        self::assertCount(
            0,
            $this->subject->getPosts(),
        );
    }

    public function testGetPostsWillReturnPosts(): void
    {
        $posts = new ObjectStorage();
        $posts->attach(new Post());

        $this->subject->_setProperty('posts', $posts);

        self::assertSame(
            $posts,
            $this->subject->getPosts(),
        );
    }

    public function testAddPostWillAddPost(): void
    {
        $this->subject->setPosts(new ObjectStorage());
        $this->subject->addPost(new Post());

        self::assertCount(
            1,
            $this->subject->getPosts(),
        );
    }

    public function testSetPostsWillSetPosts(): void
    {
        $posts = new ObjectStorage();
        $posts->attach(new Post());

        $this->subject->setPosts($posts);

        self::assertSame(
            $posts,
            $this->subject->getPosts(),
        );
    }

    public function testRemovePostWillRemovePost(): void
    {
        $post1 = new Post();
        $post2 = new Post();

        $posts = new ObjectStorage();
        $posts->attach($post1);
        $posts->attach($post2);

        $this->subject->_setProperty('posts', $posts);
        $this->subject->removePost($post1);

        self::assertCount(
            1,
            $this->subject->getPosts(),
        );
    }

    public function testRemoveAllPostWillRemoveAllPosts(): void
    {
        $post1 = new Post();
        $post2 = new Post();

        $posts = new ObjectStorage();
        $posts->attach($post1);
        $posts->attach($post2);

        $this->subject->_setProperty('posts', $posts);
        $this->subject->removeAllPosts();

        self::assertCount(
            0,
            $this->subject->getPosts(),
        );
    }

    public function testCategoriesWillInitiallyReturnEmptyObjectStorage(): void
    {
        $posts = $this->subject->getPosts();

        self::assertInstanceOf(
            ObjectStorage::class,
            $posts,
        );

        self::assertCount(
            0,
            $this->subject->getCategories(),
        );
    }

    public function testGetCategoriesWillReturnCategories(): void
    {
        $categories = new ObjectStorage();
        $categories->attach(new Category());

        $this->subject->_setProperty('categories', $categories);

        self::assertSame(
            $categories,
            $this->subject->getCategories(),
        );
    }

    public function testAddCategoryWillAddCategory(): void
    {
        $this->subject->setCategories(new ObjectStorage());
        $this->subject->addCategory(new Category());

        self::assertCount(
            1,
            $this->subject->getCategories(),
        );
    }

    public function testSetCategoriesWillSetCategories(): void
    {
        $categories = new ObjectStorage();
        $categories->attach(new Category());

        $this->subject->setCategories($categories);

        self::assertSame(
            $categories,
            $this->subject->getCategories(),
        );
    }

    public function testRemoveCategoryWillRemoveCategory(): void
    {
        $category1 = new Category();
        $category2 = new Category();

        $categories = new ObjectStorage();
        $categories->attach($category1);
        $categories->attach($category2);

        $this->subject->_setProperty('categories', $categories);
        $this->subject->removeCategory($category1);

        self::assertCount(
            1,
            $this->subject->getCategories(),
        );
    }

    public function testAdministratorWillInitiallyReturnNull(): void
    {
        self::assertNull(
            $this->subject->administrator,
        );
    }
}
