<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Controller;

use FriendsOfTYPO3\BlogExample\Domain\Model\Comment;
use FriendsOfTYPO3\BlogExample\Domain\Model\Post;
use FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository;
use FriendsOfTYPO3\BlogExample\Exception\NoBlogAdminAccessException;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

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
     * CommentController constructor.
     *
     * Takes care of dependency injection
     */
    public function __construct(
        protected readonly PostRepository $postRepository
    ) {
    }

    /**
     * Adds a comment to a blog post and redirects to single view
     */
    public function createAction(
        Post $post,
        Comment $newComment
    ): ResponseInterface {
        $post->addComment($newComment);
        $this->postRepository->update($post);
        $this->addFlashMessage('created');
        return $this->redirect('show', 'Post', null, ['post' => $post]);
    }

    /**
     * Deletes an existing comment
     * @throws NoBlogAdminAccessException
     */
    public function deleteAction(
        Post $post,
        Comment $comment
    ): ResponseInterface {
        $this->checkBlogAdminAccess();
        $post->removeComment($comment);
        $this->postRepository->update($post);
        $this->addFlashMessage('deleted', ContextualFeedbackSeverity::INFO);
        return $this->redirect('show', 'Post', null, ['post' => $post]);
    }

    /**
     * Deletes all comments of the given post
     * @throws NoBlogAdminAccessException
     */
    public function deleteAllAction(Post $post): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $post->removeAllComments();
        $this->postRepository->update($post);
        $this->addFlashMessage('deletedAll', ContextualFeedbackSeverity::INFO);
        return $this->redirect('edit', 'Post', null,
            ['post' => $post, 'blog' => $post->getBlog()]);
    }
}
