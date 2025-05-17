<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Controller;

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Comment;
use T3docs\BlogExample\Domain\Model\Post;
use T3docs\BlogExample\Domain\Repository\CommentRepository;
use T3docs\BlogExample\Domain\Repository\PostRepository;
use T3docs\BlogExample\Exception\NoBlogAdminAccessException;
use T3docs\BlogExample\Property\TypeConverters\HiddenCommentConverter;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;

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
        protected readonly PostRepository $postRepository,
        protected readonly CommentRepository $commentRepository,
        protected readonly HiddenCommentConverter $hiddenCommentConverter,
    ) {}

    /**
     * Adds a comment to a blog post and redirects to single view
     */
    public function createAction(
        Post $post,
        Comment $newComment,
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
        Comment $comment,
    ): ResponseInterface {
        $this->checkBlogAdminAccess();
        $post->removeComment($comment);
        $this->postRepository->update($post);
        $this->addFlashMessage('deleted', '', ContextualFeedbackSeverity::INFO);
        return $this->redirect('show', 'Post', null, ['post' => $post]);
    }

    /**
     * @throws NoSuchArgumentException
     */
    public function initializePublishAction(): void
    {
        $this->arguments->getArgument('comment')
            ->getPropertyMappingConfiguration()
            ->setTypeConverter($this->hiddenCommentConverter);
    }

    public function publishAction(
        Post $post,
        Comment $comment,
    ): ResponseInterface {
        $this->checkBlogAdminAccess();
        $comment->setHidden(false);
        $this->commentRepository->update($comment);
        $this->addFlashMessage('published', '', ContextualFeedbackSeverity::INFO);
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
        $this->addFlashMessage('deletedAll', '', ContextualFeedbackSeverity::INFO);
        return $this->redirect(
            'edit',
            'Post',
            null,
            ['post' => $post, 'blog' => $post->getBlog()],
        );
    }
}
