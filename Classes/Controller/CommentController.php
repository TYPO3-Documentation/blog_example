<?php
declare(strict_types = 1);

namespace FriendsOfTYPO3\BlogExample\Controller;

use FriendsOfTYPO3\BlogExample\Domain\Model\Comment;
use FriendsOfTYPO3\BlogExample\Domain\Model\Post;
use FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;

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
 * The comment controller for the BlogExample extension
 */
class CommentController extends AbstractController
{
    /**
     * @var \FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository
     */
    private $postRepository;


    /**
     * @param \FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Adds a comment to a blog post and redirects to single view
     *
     * @param Post $post The post the comment is related to
     * @param Comment $newComment The comment to create
     * @return void
     */
    public function createAction(Post $post, Comment $newComment): void
    {
        $post->addComment($newComment);
        $this->postRepository->update($post);
        $this->addFlashMessage('created');
        $this->redirect('show', 'Post', null, ['post' => $post]);
    }

    /**
     * Deletes an existing comment
     *
     * @param Post $post The post the comment is related to
     * @param Comment $comment The comment to be deleted
     * @return void
     */
    public function deleteAction(Post $post, Comment $comment): void
    {
        // TODO access protection
        $post->removeComment($comment);
        $this->postRepository->update($post);
        $this->addFlashMessage('deleted', FlashMessage::INFO);
        $this->redirect('show', 'Post', null, ['post' => $post]);
    }

    /**
     * Deletes all comments of the given post
     *
     * @param \FriendsOfTYPO3\BlogExample\Domain\Model\Post $post
     */
    public function deleteAllAction(Post $post): void
    {
        // TODO access protection
        $post->removeAllComments();
        $this->postRepository->update($post);
        $this->addFlashMessage('deletedAll', FlashMessage::INFO);
        $this->redirect('edit', 'Post', null, ['post' => $post, 'blog' => $post->getBlog()]);
    }
}
