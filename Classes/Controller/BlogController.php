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
use FriendsOfTYPO3\BlogExample\Service\BlogFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

/**
 * The blog controller for the BlogExample extension
 */
class BlogController extends AbstractController
{
    protected BlogRepository $blogRepository;

    protected AdministratorRepository $administratorRepository;

    public function __construct(BlogRepository $blogRepository, AdministratorRepository $administratorRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->administratorRepository = $administratorRepository;
    }

    /**
     * Index action for this controller. Displays a list of blogs.
     */
    public function indexAction(int $currentPage = 1): void
    {
        $allAvailableBlogs = $this->blogRepository->findAll();
        $paginator = new QueryResultPaginator($allAvailableBlogs, $currentPage, 3);
        $pagination = new SimplePagination($paginator);
        $this->view
            ->assign('blogs', $allAvailableBlogs)
            ->assign('paginator', $paginator)
            ->assign('pagination', $pagination)
            ->assign('pages', range(1, $pagination->getLastPageNumber()));
    }

    /**
     * Displays a form for creating a new blog
     *
     * @IgnoreValidation("newBlog")
     */
    public function newAction(?Blog $newBlog = null): void
    {
        $this->view->assign('newBlog', $newBlog);
        $this->view->assign('administrators', $this->administratorRepository->findAll());
    }

    /**
     * Creates a new blog
     *
     * @param Blog $newBlog A fresh Blog object which has not yet been added to the repository
     */
    public function createAction(Blog $newBlog): void
    {
        // TODO access protection
        $this->blogRepository->add($newBlog);
        $this->addFlashMessage('created');
        $this->redirect('index');
    }

    /**
     * Displays a form for editing an existing blog
     *
     * @param Blog $blog The blog to be edited. This might also be a clone of the original blog already containing
     *     modifications if the edit form has been submitted, contained errors and therefore ended up in this action
     *     again.
     * @IgnoreValidation("blog")
     */
    public function editAction(Blog $blog): void
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('administrators', $this->administratorRepository->findAll());
    }

    /**
     * Updates an existing blog
     *
     * @param Blog $blog A not yet persisted clone of the original blog containing the modifications
     */
    public function updateAction(Blog $blog): void
    {
        // TODO access protection
        $this->blogRepository->update($blog);
        $this->addFlashMessage('updated');
        $this->redirect('index');
    }

    /**
     * Deletes an existing blog
     */
    public function deleteAction(Blog $blog): void
    {
        // TODO access protection
        $this->blogRepository->remove($blog);
        $this->addFlashMessage('deleted', FlashMessage::INFO);
        $this->redirect('index');
    }

    /**
     * Deletes an existing blog
     */
    public function deleteAllAction(): void
    {
        // TODO access protection
        $this->blogRepository->removeAll();
        $this->redirect('index');
    }

    /**
     * Creates a several new blogs
     */
    public function populateAction(): void
    {
        // TODO access protection
        $numberOfExistingBlogs = $this->blogRepository->countAll();
        $blogFactory = $this->objectManager->get(BlogFactory::class);
        for ($blogNumber = $numberOfExistingBlogs + 1; $blogNumber < ($numberOfExistingBlogs + 5); $blogNumber++) {
            $blog = $blogFactory->createBlog($blogNumber);
            $this->blogRepository->add($blog);
        }
        $this->addFlashMessage('populated');
        $this->redirect('index');
    }
}

