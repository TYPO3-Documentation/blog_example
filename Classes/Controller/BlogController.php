<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Controller;

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

use FriendsOfTYPO3\BlogExample\Domain\Model\Blog;
use FriendsOfTYPO3\BlogExample\Domain\Repository\AdministratorRepository;
use FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository;
use FriendsOfTYPO3\BlogExample\Exception\NoBlogAdminAccessException;
use FriendsOfTYPO3\BlogExample\Service\BlogFactory;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * The blog controller for the BlogExample extension
 */
class BlogController extends AbstractController
{

    /**
     * BlogController constructor.
     *
     * Takes care of dependency injection
     */
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly BlogFactory $blogFactory,
        protected readonly AdministratorRepository $administratorRepository
    ) {
    }

    /**
     * Index action for this controller. Displays a list of blogs.
     */
    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $allAvailableBlogs = $this->blogRepository->findAll();
        $paginator = new QueryResultPaginator($allAvailableBlogs, $currentPage,
            3);
        $pagination = new SimplePagination($paginator);
        $this->view
            ->assign('blogs', $allAvailableBlogs)
            ->assign('paginator', $paginator)
            ->assign('pagination', $pagination)
            ->assign('pages', range(1, $pagination->getLastPageNumber()));
        return $this->htmlResponse();
    }


    /**
     * Output <h1>Hello World!</h1>
     */
    public function helloWorldAction(): ResponseInterface
    {
        return $this->htmlResponse('<h1>Hello World!</h1>');
    }

    /**
     * Displays a form for creating a new blog
     *
     * $newBlog is taken as a basis for the rendering
     *
     * @IgnoreValidation("newBlog")
     */
    public function newAction(Blog $newBlog = null): ResponseInterface
    {
        $this->view->assign('newBlog', $newBlog);
        $this->view->assign('administrators',
            $this->administratorRepository->findAll());
        return $this->htmlResponse();
    }

    /**
     * Creates a new blog
     *
     * $blog is a fresh Blog object which has not yet been added to the
     * repository
     *
     * @Validate(param="newBlog", validator="FriendsOfTYPO3\BlogExample\Domain\Validator\BlogValidator")
     */
    public function createAction(Blog $newBlog): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $this->blogRepository->add($newBlog);
        $this->addFlashMessage('created');
        return $this->redirect('index');
    }

    /**
     * Displays a form for editing an existing blog
     *
     * $blog might also be a clone of the original blog already containing
     * modifications if the edit form has been submitted, contained errors and
     * therefore ended up in this action again.
     *
     * @IgnoreValidation("blog")
     */
    public function editAction(Blog $blog): ResponseInterface
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('administrators',
            $this->administratorRepository->findAll());
        return $this->htmlResponse();
    }

    /**
     * Updates an existing blog
     *
     * $blog is a not yet persisted clone of the original blog containing
     * the modifications
     *
     * @Validate(param="blog", validator="FriendsOfTYPO3\BlogExample\Domain\Validator\BlogValidator")
     * @throws NoBlogAdminAccessException
     */
    public function updateAction(Blog $blog): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $this->blogRepository->update($blog);
        $this->addFlashMessage('updated');
        return $this->redirect('index');
    }

    /**
     * Deletes an existing blog
     * @throws NoBlogAdminAccessException
     */
    public function deleteAction(Blog $blog): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $this->blogRepository->remove($blog);
        $this->addFlashMessage('deleted', ContextualFeedbackSeverity::INFO);
        return $this->redirect('index');
    }

    /**
     * Deletes an existing blog
     * @throws NoBlogAdminAccessException
     */
    public function deleteAllAction(): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $this->blogRepository->removeAll();
        return $this->redirect('index');
    }


    /**
     * Creates a several new blogs
     * @throws NoBlogAdminAccessException
     */
    public function populateAction(): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $numberOfExistingBlogs = $this->blogRepository->countAll();
        for ($blogNumber = $numberOfExistingBlogs + 1; $blogNumber < ($numberOfExistingBlogs + 5); $blogNumber++) {
            $blog = $this->blogFactory->createBlog($blogNumber);
            $this->blogRepository->add($blog);
        }
        $this->addFlashMessage('populated');
        return $this->redirect('index');
    }

    public function showBlogAjaxAction(Blog $blog): ResponseInterface
    {
        $jsonOutput = json_encode($blog);
        return $this->jsonResponse($jsonOutput);
    }
}

