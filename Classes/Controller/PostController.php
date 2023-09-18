<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Controller;

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Model\Comment;
use T3docs\BlogExample\Domain\Model\Post;
use T3docs\BlogExample\Domain\Model\Tag;
use T3docs\BlogExample\Domain\Repository\BlogRepository;
use T3docs\BlogExample\Domain\Repository\PersonRepository;
use T3docs\BlogExample\Domain\Repository\PostRepository;
use T3docs\BlogExample\Exception\NoBlogAdminAccessException;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Property\PropertyMapper;

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
class PostController extends \T3docs\BlogExample\Controller\AbstractController
{
    /**
     * PostController constructor.
     *
     * Takes care of dependency injection
     */
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PostRepository $postRepository,
        protected readonly PropertyMapper $propertyMapper
    ) {}

    /**
     * This method demonstrates property mapping to an object
     * @throws \TYPO3\CMS\Extbase\Property\Exception
     */
    protected function mapTagFromString(string $tagString = 'some tag'): Tag
    {
        $input = [
            'name' => $tagString,
        ];
        return $this->propertyMapper->convert(
            $input,
            Tag::class
        );
    }

    /**
     * This method demonstrates property mapping to an integer
     * @throws \TYPO3\CMS\Extbase\Property\Exception
     */
    protected function mapIntegerFromString(string $numberString = '42'): int
    {
        return $output = $this->propertyMapper->convert($numberString, 'integer');
    }

    /**
     * Displays a list of posts. If $tag is set only posts matching this tag are shown
     */
    public function indexAction(
        ?Blog $blog = null,
        string $tag = '',
        int $currentPage = 1
    ): ResponseInterface {
        if ($blog == null) {
            return (new ForwardResponse('index'))
                ->withControllerName(('Blog'))
                ->withExtensionName('blog_example')
                ->withArguments(['currentPage' => $currentPage]);
        }
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
        return $this->htmlResponse();
    }

    /**
     * Displays a list of posts as RSS feed
     */
    public function displayRssListAction(): ResponseInterface
    {
        $defaultBlog = $this->settings['defaultBlog'] ?? 0;
        if ($defaultBlog > 0) {
            $blog = $this->blogRepository->findByUid((int)$defaultBlog);
        } else {
            $blog = $this->blogRepository->findAll()->getFirst();
        }
        $this->view->assign('blog', $blog);
        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/xml; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }

    /**
     * Displays one single post
     *
     * @IgnoreValidation("newComment")
     */
    public function showAction(
        Post $post,
        ?Comment $newComment = null
    ): ResponseInterface {
        $this->view->assign('post', $post);
        $this->view->assign('newComment', $newComment);
        return $this->htmlResponse();
    }

    /**
     * Displays a form for creating a new post
     *
     * $newPost is a fresh post object taken as a basis for the rendering
     *
     * @IgnoreValidation("newPost")
     */
    public function newAction(
        Blog $blog,
        ?Post $newPost = null
    ): ResponseInterface {
        $this->view->assign('authors', $this->personRepository->findAll());
        $this->view->assign('blog', $blog);
        $this->view->assign('newPost', $newPost);
        $this->view->assign(
            'remainingPosts',
            $this->postRepository->findByBlog($blog)
        );
        return $this->htmlResponse();
    }

    /**
     * Creates a new post
     * @throws NoBlogAdminAccessException|IllegalObjectTypeException
     */
    public function createAction(
        Blog $blog,
        Post $newPost
    ): ResponseInterface {
        $this->checkBlogAdminAccess();
        $blog->addPost($newPost);
        $newPost->setBlog($blog);
        $this->postRepository->add($newPost);
        $this->addFlashMessage('created');
        return $this->redirect('index', null, null, ['blog' => $blog]);
    }

    /**
     * Displays a form to edit an existing post
     *
     * @IgnoreValidation("post")
     */
    public function editAction(Blog $blog, Post $post): ResponseInterface
    {
        $this->view->assign('authors', $this->personRepository->findAll());
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
        $this->view->assign(
            'remainingPosts',
            $this->postRepository->findRemaining($post)
        );
        return $this->htmlResponse();
    }

    /**
     * Updates an existing post
     *
     * $post is a clone of the original post with the updated values already applied
     *
     * @throws NoBlogAdminAccessException
     */
    public function updateAction(
        Blog $blog,
        Post $post
    ): ResponseInterface {
        $this->checkBlogAdminAccess();
        $this->postRepository->update($post);
        $this->addFlashMessage('updated');
        return $this->redirect(
            'show',
            null,
            null,
            ['post' => $post, 'blog' => $blog]
        );
    }

    /**
     * Deletes an existing post
     * @throws NoBlogAdminAccessException
     */
    public function deleteAction(
        Blog $blog,
        Post $post
    ): ResponseInterface {
        $this->checkBlogAdminAccess();
        $this->postRepository->remove($post);
        $this->addFlashMessage('deleted', ContextualFeedbackSeverity::INFO);
        return $this->redirect('index', null, null, ['blog' => $blog]);
    }
}
