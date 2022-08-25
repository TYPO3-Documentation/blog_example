<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Controller;

use FriendsOfTYPO3\BlogExample\Domain\Model\Blog;
use FriendsOfTYPO3\BlogExample\Domain\Model\Comment;
use FriendsOfTYPO3\BlogExample\Domain\Model\Post;
use FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository;
use FriendsOfTYPO3\BlogExample\Domain\Repository\PersonRepository;
use FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

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
 * The post controller for the BlogExample extension
 */
class PostController extends \FriendsOfTYPO3\BlogExample\Controller\AbstractController
{
    protected BlogRepository $blogRepository;

    protected PostRepository $postRepository;

    protected PersonRepository $personRepository;

    public function __construct(
        BlogRepository $blogRepository,
        PersonRepository $personRepository,
        PostRepository $postRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->personRepository = $personRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Displays a list of posts. If $tag is set only posts matching this tag are shown
     *
     * @param Blog|null $blog The blog to show the posts of
     * @param string $tag The name of the tag to show the posts for
     */
    public function indexAction(?Blog $blog = null, string $tag = '', int $currentPage = 1): void
    {
        if ($blog == null) {
            $defaultBlog = $this->settings['defaultBlog'] ?? 0;
            if ($defaultBlog > 0) {
                $blog = $this->blogRepository->findByUid((int)$defaultBlog);
            } else {
                $blog = $this->blogRepository->findAll()->getFirst();
            }
        }
        if ($blog == null) {
            $this->view->assign('blog', 0);
        } else {
            if (empty($tag)) {
                $posts = $this->postRepository->findByBlog($blog);
            } else {
                $tag = urldecode($tag);
                $posts = $this->postRepository->findByTagAndBlog($tag, $blog);
                $this->view->assign('tag', $tag);
            }
            $paginator = new QueryResultPaginator($posts, $currentPage, 3);
            $pagination = new SimplePagination($paginator);
            $this->view
                ->assign('paginator', $paginator)
                ->assign('pagination', $pagination)
                ->assign('pages', range(1, $pagination->getLastPageNumber()))
                ->assign('blog', $blog)
                ->assign('posts', $posts);
        }
    }

    /**
     * Displays a list of posts as Rss feed
     */
    public function displayRssListAction(): void
    {
        $defaultBlog = $this->settings['defaultBlog'] ?? 0;
        if ($defaultBlog > 0) {
            $blog = $this->blogRepository->findByUid((int)$defaultBlog);
        } else {
            $blog = $this->blogRepository->findAll()->getFirst();
        }
        $this->view->assign('blog', $blog);
    }

    /**
     * Displays one single post
     *
     * @param Post $post The post to display
     * @param Comment|null $newComment A new comment
     *
     * @IgnoreValidation("newComment")
     */
    public function showAction(Post $post, ?Comment $newComment = null): void
    {
        $this->view->assign('post', $post);
        $this->view->assign('newComment', $newComment);
    }

    /**
     * Displays a form for creating a new post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post|null $newPost A fresh post object taken as a basis for the rendering
     *
     * @IgnoreValidation("newPost")
     */
    public function newAction(Blog $blog, ?Post $newPost = null): void
    {
        $this->view->assign('authors', $this->personRepository->findAll());
        $this->view->assign('blog', $blog);
        $this->view->assign('newPost', $newPost);
        $this->view->assign('remainingPosts', $this->postRepository->findByBlog($blog));
    }

    /**
     * Creates a new post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $newPost The new post object
     */
    public function createAction(Blog $blog, Post $newPost): void
    {
        // TODO access protection
        $blog->addPost($newPost);
        $newPost->setBlog($blog);
        $this->postRepository->add($newPost);
        $this->addFlashMessage('created');
        $this->redirect('index', null, null, ['blog' => $blog]);
    }

    /**
     * Displays a form to edit an existing post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $post The original post
     *
     * @IgnoreValidation("post")
     */
    public function editAction(Blog $blog, Post $post): void
    {
        $this->view->assign('authors', $this->personRepository->findAll());
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
        $this->view->assign('remainingPosts', $this->postRepository->findRemaining($post));
    }

    /**
     * Updates an existing post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $post A clone of the original post with the updated values already applied
     */
    public function updateAction(Blog $blog, Post $post): void
    {
        // TODO access protection
        $this->postRepository->update($post);
        $this->addFlashMessage('updated');
        $this->redirect('show', null, null, ['post' => $post, 'blog' => $blog]);
    }

    /**
     * Deletes an existing post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $post The post to be deleted
     */
    public function deleteAction(Blog $blog, Post $post): void
    {
        // TODO access protection
        $this->postRepository->remove($post);
        $this->addFlashMessage('deleted', FlashMessage::INFO);
        $this->redirect('index', null, null, ['blog' => $blog]);
    }
}
