<?php

namespace ExtbaseTeam\BlogExample\Controller;

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

use ExtbaseTeam\BlogExample\Domain\Model\Blog;
use ExtbaseTeam\BlogExample\Domain\Repository\AdministratorRepository;
use ExtbaseTeam\BlogExample\Service\BlogFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;

/**
 * The blog controller for the BlogExample extension
 */
class BlogController extends AbstractController
{

    /**
     * @var \ExtbaseTeam\BlogExample\Domain\Repository\BlogRepository
     */
    protected $blogRepository;

    /**
     * @var \ExtbaseTeam\BlogExample\Domain\Repository\AdministratorRepository
     */
    protected $administratorRepository;

    /**
     * Dependency injection of the Blog Repository
     *
     * @param \ExtbaseTeam\BlogExample\Domain\Repository\BlogRepository $blogRepository
     * @return void
     */
    public function injectBlogRepository(\ExtbaseTeam\BlogExample\Domain\Repository\BlogRepository $blogRepository): void
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Dependency injection of the Administrator Repository
     *
     * @param \ExtbaseTeam\BlogExample\Domain\Repository\AdministratorRepository $administratorRepository
     * @return void
     */
    public function injectAdministratorRepository(AdministratorRepository $administratorRepository): void
    {
        $this->administratorRepository = $administratorRepository;
    }

    /**
     * Index action for this controller. Displays a list of blogs.
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('blogs', $this->blogRepository->findAll());
    }

    /**
     * Displays a form for creating a new blog
     *
     * @param Blog $newBlog A fresh blog object taken as a basis for the rendering
     * @return void
     * @IgnoreValidation $newBlog
     */
    public function newAction(Blog $newBlog = null)
    {
        $this->view->assign('newBlog', $newBlog);
        $this->view->assign('administrators', $this->administratorRepository->findAll());
    }

    /**
     * Creates a new blog
     *
     * @param Blog $newBlog A fresh Blog object which has not yet been added to the repository
     * @return void
     */
    public function createAction(Blog $newBlog)
    {
        // TODO access protection
        $this->blogRepository->add($newBlog);
        $this->addFlashMessage('created');
        $this->redirect('index');
    }

    /**
     * Displays a form for editing an existing blog
     *
     * @param Blog $blog The blog to be edited. This might also be a clone of the original blog already containing modifications if the edit form has been submitted, contained errors and therefore ended up in this action again.
     * @return void
     * @IgnoreValidation $blog
     */
    public function editAction(Blog $blog)
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('administrators', $this->administratorRepository->findAll());
    }

    /**
     * Updates an existing blog
     *
     * @param Blog $blog A not yet persisted clone of the original blog containing the modifications
     * @return void
     */
    public function updateAction(Blog $blog)
    {
        // TODO access protection
        $this->blogRepository->update($blog);
        $this->addFlashMessage('updated');
        $this->redirect('index');
    }

    /**
     * Deletes an existing blog
     *
     * @param Blog $blog The blog to delete
     * @return void
     */
    public function deleteAction(Blog $blog)
    {
        // TODO access protection
        $this->blogRepository->remove($blog);
        $this->addFlashMessage('deleted', FlashMessage::INFO);
        $this->redirect('index');
    }

    /**
     * Deletes an existing blog
     *
     * @return void
     */
    public function deleteAllAction()
    {
        // TODO access protection
        $this->blogRepository->removeAll();
        $this->redirect('index');
    }


    /**
     * Creates a several new blogs
     *
     * @return void
     */
    public function populateAction()
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

