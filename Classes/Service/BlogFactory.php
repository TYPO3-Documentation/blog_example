<?php
declare(strict_types = 1);

namespace ExtbaseTeam\BlogExample\Service;

use DateTime;
use ExtbaseTeam\BlogExample\Domain\Model\Administrator;
use ExtbaseTeam\BlogExample\Domain\Model\Blog;
use ExtbaseTeam\BlogExample\Domain\Model\Comment;
use ExtbaseTeam\BlogExample\Domain\Model\Person;
use ExtbaseTeam\BlogExample\Domain\Model\Post;
use ExtbaseTeam\BlogExample\Domain\Model\Tag;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

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
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Injects the object manager
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Returns a sample blog populated with generic data
     * It is also an example how to handle objects and repositories in general
     *
     * @param integer $blogNumber
     * @return \ExtbaseTeam\BlogExample\Domain\Model\Blog
     */
    public function createBlog($blogNumber = 1)
    {
        // initialize blog
        $blog = $this->objectManager->get(Blog::class);
        $blog->setTitle('Blog #' . $blogNumber);
        $blog->setDescription('A blog about TYPO3 extension development.');

        // create author
        $author = $this->objectManager->get(Person::class, 'Stephen', 'Smith', 'foo.bar@example.com');

        // create administrator
        $administrator = $this->objectManager->get(Administrator::class);
        $administrator->setName('John Doe');
        $administrator->setEmail('john.doe@example.com');
        $blog->setAdministrator($administrator);

        // create sample posts
        for ($postNumber = 1; $postNumber < 6; $postNumber++) {

            // create post
            $post = $this->objectManager->get(Post::class);
            $post->setTitle('The ' . $postNumber . '. post of blog #' . $blogNumber);
            $post->setAuthor($author);
            $post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

            // create comments
            $comment = $this->objectManager->get(Comment::class);
            $comment->setDate(new DateTime());
            $comment->setAuthor('Peter Pan');
            $comment->setEmail('peter.pan@example.com');
            $comment->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
            $post->addComment($comment);

            $comment = $this->objectManager->get(Comment::class);
            $comment->setDate(new DateTime('2009-03-19 23:44'));
            $comment->setAuthor('John Smith');
            $comment->setEmail('john@matrix.org');
            $comment->setContent('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
            $post->addComment($comment);

            // create some random tags
            if (random_int(0, 1) > 0) {
                $tag = $this->objectManager->get(Tag::class, 'MVC');
                $post->addTag($tag);
            }
            if (random_int(0, 1) > 0) {
                $tag = $this->objectManager->get(Tag::class, 'Domain Driven Design');
                $post->addTag($tag);
            }
            if (random_int(0, 1) > 0) {
                $tag = $this->objectManager->get(Tag::class, 'TYPO3');
                $post->addTag($tag);
            }
            // add the post to the current blog
            $blog->addPost($post);
            $post->setBlog($blog);
        }
        return $blog;
    }
}
