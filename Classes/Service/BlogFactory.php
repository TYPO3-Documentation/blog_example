<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Service;

use T3docs\BlogExample\Domain\Model\Administrator;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Model\Comment;
use T3docs\BlogExample\Domain\Model\Post;

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
 * A simple blog factory to create sample data
 */
readonly class BlogFactory
{
    /**
     * Returns a sample blog populated with generic data
     * It is also an example how to handle objects and repositories in general
     */
    public function createBlog(?Administrator $administrator = null, int $blogNumber = 1, ?\DateTimeImmutable $baseDate = null): Blog
    {
        $baseDate ??= new \DateTimeImmutable('2026-01-01 12:00:00');
        // initialize blog
        $blog = new Blog();
        $blog->setTitle('Blog #' . $blogNumber);
        $blog->description = 'A blog about TYPO3 extension development.';

        if ($administrator !== null) {
            $blog->administrator = $administrator;
        }

        // create sample posts
        for ($postNumber = 1; $postNumber < 6; $postNumber++) {
            // create post
            $post = new Post();
            $post->setTitle('The ' . $postNumber . '. post of blog #' . $blogNumber);
            $post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

            // create comments
            $comment = new Comment();

            $comment->setDate(\DateTime::createFromImmutable(
                $baseDate->modify(sprintf('+%d days', $postNumber)),
            ));
            $comment->setAuthor('Peter Pan');
            $comment->setEmail(sprintf('peter.pan%d@example.com', $blogNumber));
            $comment->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
            $comment->setHidden(false);
            $post->addComment($comment);

            $comment = new Comment();
            $comment->setDate(\DateTime::createFromImmutable(
                $baseDate->modify(sprintf('+%d days', $postNumber + 1)),
            ));
            $comment->setAuthor('John Smith');
            $comment->setEmail(sprintf('john.smith%d@example.com', $blogNumber));
            $comment->setHidden(false);
            $comment->setContent('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
            $post->addComment($comment);

            // add the post to the current blog
            $blog->addPost($post);
            $post->setBlog($blog);
        }
        return $blog;
    }
}
