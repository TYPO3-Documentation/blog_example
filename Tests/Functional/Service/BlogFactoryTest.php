<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Tests\Service;

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

use PHPUnit\Framework\Attributes\Test;
use T3docs\BlogExample\Domain\Model\Administrator;
use T3docs\BlogExample\Service\BlogFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class BlogFactoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        't3docs/blog-example',
    ];

    #[Test]
    public function createBlogIsDeterministicAndUniquePerBlogNumber(): void
    {
        $factory = new BlogFactory();

        $administrator = new Administrator();
        $administrator->name = 'John Doe';
        $administrator->email = 'john.doe@example.com';

        $baseDate = new \DateTimeImmutable('2026-01-01 12:00:00');

        $blog1 = $factory->createBlog($administrator, 1, $baseDate);
        $blog2 = $factory->createBlog($administrator, 2, $baseDate);

        self::assertSame('Blog #1', $blog1->getTitle());
        self::assertSame('Blog #2', $blog2->getTitle());

        // Administrator is the same object on both blogs (by design)
        self::assertSame('john.doe@example.com', $blog1->administrator?->email);
        self::assertSame('john.doe@example.com', $blog2->administrator?->email);

        // Safer: rewind storages before current()
        $posts1 = $blog1->getPosts();
        $posts1->rewind();
        $post1Blog1 = $posts1->current();

        $posts2 = $blog2->getPosts();
        $posts2->rewind();
        $post1Blog2 = $posts2->current();

        $comments1 = $post1Blog1->getComments();
        $comments1->rewind();
        $firstComment1 = $comments1->current();

        $comments2 = $post1Blog2->getComments();
        $comments2->rewind();
        $firstComment2 = $comments2->current();

        self::assertNotSame($firstComment1->getEmail(), $firstComment2->getEmail());

        $firstCommentDate = $firstComment1->getDate();
        self::assertSame('2026-01-02 12:00:00', $firstCommentDate->format('Y-m-d H:i:s'));
    }
}
