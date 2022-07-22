<?php
declare(strict_types = 1);

namespace FriendsOfTYPO3\BlogExample\Controller;

use FriendsOfTYPO3\BlogExample\Domain\Model\Blog;
use FriendsOfTYPO3\BlogExample\Domain\Model\Comment;
use FriendsOfTYPO3\BlogExample\Domain\Model\Post;
use FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository;
use FriendsOfTYPO3\BlogExample\Domain\Repository\PersonRepository;
use FriendsOfTYPO3\BlogExample\Domain\Repository\PostRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
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
 * The post controller for the BlogExample extension
 */
class BackendPostController extends AbstractBackendController
{

    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PostRepository $postRepository,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory)
    {
    }

    /**
     * Displays a list of posts. If $tag is set only posts matching this tag are shown
     */
    public function indexAction(Blog $blog = null, String $tag = '', int $currentPage = 1): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        if ($blog == null) {
            $defaultBlog = $this->settings['defaultBlog'] ?? 0;
            if ($defaultBlog > 0) {
                $blog = $this->blogRepository->findByUid((int) $defaultBlog);
            } else {
                $blog = $this->blogRepository->findAll()->getFirst();
            }
        }
        if ($blog == null) {
            $view->assign('blog', 0);

            $view->assignMultiple([
                'blog' => 0,
            ]);
        } else {
            if (empty($tag)) {
                $posts = $this->postRepository->findByBlog($blog);
            } else {
                $tag = urldecode($tag);
                $posts = $this->postRepository->findByTagAndBlog($tag, $blog);
                $view->assign('tag', $tag);
            }
            $paginator = new QueryResultPaginator($posts, $currentPage, 3);
            $pagination = new SimplePagination($paginator);

            $view->assignMultiple([
                'blog' => $blog,
                'posts' => $posts,
                'paginator' => $paginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
            ]);
        }
        return $view->renderResponse('Index');
    }

    /**
     * Displays one single post
     *
     * @param \FriendsOfTYPO3\BlogExample\Domain\Model\Post $post The post to display
     * @param \FriendsOfTYPO3\BlogExample\Domain\Model\Comment $newComment A new comment
     * @return void
     * @IgnoreValidation("newComment")
     */
    public function showAction(Post $post, Comment $newComment = null): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $view->assign('post', $post);
        $view->assign('newComment', $newComment);
        return $view->renderResponse('Show');
    }

    /**
     * Displays a form for creating a new post
     *
     * @param Blog $blog The blog the post belogs to
     * @param Post $newPost A fresh post object taken as a basis for the rendering
     * @return void
     * @IgnoreValidation("newPost")
     */
    public function newAction(Blog $blog, Post $newPost = null): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $view->assign('authors', $this->personRepository->findAll());
        $view->assign('blog', $blog);
        $view->assign('newPost', $newPost);
        $view->assign('remainingPosts', $this->postRepository->findByBlog($blog));
        return $view->renderResponse('New');
    }

    /**
     * Creates a new post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $newPost The new post object
     * @return void
     */
    public function createAction(Blog $blog, Post $newPost): ResponseInterface
    {
        $blog->addPost($newPost);
        $newPost->setBlog($blog);
        $this->postRepository->add($newPost);
        $this->addFlashMessage('created');
        return $this->redirect('index', null, null, ['blog' => $blog]);
    }

    /**
     * Displays a form to edit an existing post
     *
     * @param Blog $blog The blog the post belogs to
     * @param Post $post The original post
     * @return void
     * @IgnoreValidation("post")
     */
    public function editAction(Blog $blog, Post $post): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $view->assign('authors', $this->personRepository->findAll());
        $view->assign('blog', $blog);
        $view->assign('post', $post);
        $view->assign('remainingPosts', $this->postRepository->findRemaining($post));
        return $view->renderResponse('Edit');
    }

    /**
     * Updates an existing post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $post A clone of the original post with the updated values already applied
     * @return void
     */
    public function updateAction(Blog $blog, Post $post): ResponseInterface
    {
        $this->postRepository->update($post);
        $this->addFlashMessage('updated');
        return $this->redirect('show', null, null, ['post' => $post, 'blog' => $blog]);
    }

    /**
     * Deletes an existing post
     *
     * @param Blog $blog The blog the post belongs to
     * @param Post $post The post to be deleted
     * @return void
     */
    public function deleteAction(Blog $blog, Post $post): ResponseInterface
    {
        $this->postRepository->remove($post);
        $this->addFlashMessage('deleted', ContextualFeedbackSeverity::INFO);
        return $this->redirect('index', null, null, ['blog' => $blog]);
    }
}
