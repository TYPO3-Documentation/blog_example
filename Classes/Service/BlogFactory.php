<?php
declare(strict_types = 1);

namespace FriendsOfTYPO3\BlogExample\Service;

use DateTime;
use FriendsOfTYPO3\BlogExample\Domain\Model\Administrator;
use FriendsOfTYPO3\BlogExample\Domain\Model\Blog;
use FriendsOfTYPO3\BlogExample\Domain\Model\Comment;
use FriendsOfTYPO3\BlogExample\Domain\Model\Author;
use FriendsOfTYPO3\BlogExample\Domain\Model\Post;
use FriendsOfTYPO3\BlogExample\Domain\Model\Tag;
use TYPO3\CMS\Core\SingletonInterface;

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
class BlogFactory implements SingletonInterface
{
    /**
     * Returns a sample blog populated with generic data
     * It is also an example how to handle objects and repositories in general
     *
     * @param integer $blogNumber
     * @return \FriendsOfTYPO3\BlogExample\Domain\Model\Blog
     */
    public function createBlog($blogNumber = 1)
    {
        // initialize blog
        $blog = new Blog();
        $blog->setTitle('Blog #' . $blogNumber);
        $blog->setDescription('A blog about TYPO3 extension development.');

        // create author
        $author = new Author('Stephen', 'Smith', 'foo.bar@example.com');

        // create administrator
        $administrator = new Administrator();
        $administrator->setName('John Doe');
        $administrator->setEmail('john.doe@example.com');
        $blog->setAdministrator($administrator);

        // create sample posts
        for ($postNumber = 1; $postNumber < 6; $postNumber++) {

            // create post
            $post = new Post();
            $post->setTitle('The ' . $postNumber . '. post of blog #' . $blogNumber);
            $post->setAuthor($author);
            $post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

            // create comments
            $comment = new Comment();
            $comment->setDate(new DateTime());
            $comment->setAuthor('Peter Pan');
            $comment->setEmail('peter.pan@example.com');
            $comment->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
            $post->addComment($comment);

            $comment = new Comment();
            $comment->setDate(new DateTime('2009-03-19 23:44'));
            $comment->setAuthor('John Smith');
            $comment->setEmail('john@matrix.org');
            $comment->setContent('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
            $post->addComment($comment);

            // create some random tags
            if (random_int(0, 1) > 0) {
                $tag = new Tag('MVC');
                $post->addTag($tag);
            }
            if (random_int(0, 1) > 0) {
                $tag = new Tag('Domain Driven Design');
                $post->addTag($tag);
            }
            if (random_int(0, 1) > 0) {
                $tag = new Tag('TYPO3');
                $post->addTag($tag);
            }
            // add the post to the current blog
            $blog->addPost($post);
            $post->setBlog($blog);
        }
        return $blog;
    }
}
