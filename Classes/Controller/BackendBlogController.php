<?php
declare(strict_types = 1);

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
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

/**
 * The blog controller for the BlogExample extension
 */
class BackendBlogController extends AbstractBackendController
{

    /**
     * BlogController constructor.
     *
     * @param BlogRepository $blogRepository
     */
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly BlogFactory $blogFactory,
        protected readonly AdministratorRepository $administratorRepository,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory
    ) {
    }

    /**
     * Index action for this controller. Displays a list of blogs.
     *
     * @param int $currentPage
     * @return void
     */
    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $allAvailableBlogs = $this->blogRepository->findAll();
        $paginator = new QueryResultPaginator($allAvailableBlogs, $currentPage, 3);
        $pagination = new SimplePagination($paginator);

        $view->assignMultiple([
            'blogs' => $allAvailableBlogs,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'pages' => range(1, $pagination->getLastPageNumber()),
        ]);

        return $view->renderResponse('Index');
    }


    /**
     * Deletes an existing blog
     *
     * @return void
     */
    public function deleteAllAction(): ResponseInterface
    {
        $this->blogRepository->removeAll();
        return $this->redirect('index');
    }


    /**
     * Creates a several new blogs
     *
     * @return void
     */
    public function populateAction(): ResponseInterface
    {
        $numberOfExistingBlogs = $this->blogRepository->countAll();
        for ($blogNumber = $numberOfExistingBlogs + 1; $blogNumber < ($numberOfExistingBlogs + 5); $blogNumber++) {
            $blog = $this->blogFactory->createBlog($blogNumber);
            $this->blogRepository->add($blog);
        }
        $this->addFlashMessage('populated');
        return $this->redirect('index');
    }


}
