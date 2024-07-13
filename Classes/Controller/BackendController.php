<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Controller;

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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Model\Post;
use T3docs\BlogExample\Domain\Repository\BlogRepository;
use T3docs\BlogExample\Domain\Repository\CommentRepository;
use T3docs\BlogExample\Domain\Repository\PostRepository;
use T3docs\BlogExample\Service\BlogFactory;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Menu\Menu;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

/**
 * The backend controller for the BlogExample extension
 */
class BackendController extends ActionController
{
    protected int $pageUid = 0;

    /**
     * BackendController constructor. Takes care of dependency injection
     */
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly BlogFactory $blogFactory,
        protected readonly PostRepository $postRepository,
        protected readonly CommentRepository $commentRepository,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        private readonly IconFactory $iconFactory,
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    public function addPopulateButton(ButtonBar $buttonBar): void
    {
        $populateButton = $buttonBar->makeLinkButton()
            ->setHref($this->uriBuilder->reset()->uriFor('populate'))
            ->setTitle('Create example data')
            ->setShowLabelText(true)
            ->setIcon($this->iconFactory->getIcon('actions-plus-badge', IconSize::SMALL));
        $buttonBar->addButton($populateButton);
    }

    public function addButtons(ButtonBar $buttonBar): void
    {
        $this->addPopulateButton($buttonBar);
        $this->addShortCutButton($buttonBar);
        $this->addReloadButton($buttonBar);
    }

    /**
     * @return array<string,scalar>|false
     */
    public function getMetaInformation(): array|false
    {
        $permissionClause = $GLOBALS['BE_USER']->getPagePermsClause(Permission::PAGE_SHOW);
        return BackendUtility::readPageAccess(
            $this->pageUid,
            $permissionClause,
        );
    }

    /**
     * Function will be called before every other action
     */
    protected function initializeAction(): void
    {
        $this->pageUid = (int)($this->request->getQueryParams()['id'] ?? 0);
    }

    /**
     * Index action for this controller. Displays a list of blogs.
     */
    public function indexAction(int $currentPage = 1): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $allAvailableBlogs = $this->blogRepository->findAll();
        $paginator = new QueryResultPaginator(
            $allAvailableBlogs,
            $currentPage,
            3,
        );
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
     * Deletes all blogs
     */
    public function deleteAllAction(): ResponseInterface
    {
        $this->blogRepository->removeAll();
        return $this->redirect('index');
    }
    /**
     * Deletes a blog
     */
    public function deleteBlogAction(Blog $blog): ResponseInterface
    {
        $this->blogRepository->remove($blog);
        $this->addFlashMessage(sprintf('Blog "%s" was deleted. ', $blog->title), 'Blog was deleted');
        return $this->redirect('index');
    }

    /**
     * Creates a several new blogs
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

    /**
     * Displays a list of posts. If $tag is set only posts matching this tag are shown
     */
    public function showBlogAction(
        Blog $blog = null,
        string $tag = '',
        int $currentPage = 1,
    ): ResponseInterface {
        $view = $this->initializeModuleTemplate($this->request);
        if ($blog === null) {
            $this->addFlashMessage('Blog was not found', 'Warning', ContextualFeedbackSeverity::WARNING);
            return $this->redirect('index');
        }
        if ($tag === '') {
            $posts = $this->postRepository->findBy(['blog' => $blog]);
        } else {
            $tag = urldecode($tag);
            $posts = $this->postRepository->findByTagAndBlog(urldecode($tag), $blog);
        }
        $paginator = new QueryResultPaginator($posts, $currentPage, 3);
        $pagination = new SimplePagination($paginator);

        $view->assignMultiple([
            'blog' => $blog,
            'posts' => $posts,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'pages' => range(1, $pagination->getLastPageNumber()),
            'tag' => $tag,
        ]);
        return $view->renderResponse('showBlog');
    }

    /**
     * Displays one single post
     */
    public function showPostAction(Post $post): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $view->assign('post', $post);
        return $view->renderResponse('ShowPost');
    }

    public function showAllCommentsAction(): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);
        $comments = $this->commentRepository->findAll();
        $view->assign('comments', $comments);
        return $view->renderResponse('showAllComments');
    }

    /**
     * Generates the action menu
     */
    protected function initializeModuleTemplate(
        ServerRequestInterface $request,
    ): ModuleTemplate {
        $view = $this->moduleTemplateFactory->create($request);

        $context = '';
        $this->modifyDocHeaderComponent($view, $context);
        $view->setFlashMessageQueue($this->getFlashMessageQueue());
        $view->setTitle(
            $this->getLanguageService()->sL('LLL:EXT:blog_example/Resources/Private/Language/Module/locallang_mod.xlf:mlang_tabs_tab'),
            $context,
        );

        return $view;
    }

    private function modifyDocHeaderComponent(ModuleTemplate $view, string &$context): void
    {
        $menu = $this->buildMenu($view, $context);
        $view->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);

        $buttonBar = $view->getDocHeaderComponent()->getButtonBar();
        $this->addButtons($buttonBar);

        $metaInformation = $this->getMetaInformation();
        if (is_array($metaInformation)) {
            $view->getDocHeaderComponent()->setMetaInformation($metaInformation);
        }
    }

    private function addReloadButton(ButtonBar $buttonBar): void
    {
        $reloadButton = $buttonBar->makeLinkButton()
            ->setHref($this->request->getAttribute('normalizedParams')->getRequestUri())
            ->setTitle($this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.reload'))
            ->setIcon($this->iconFactory->getIcon('actions-refresh', IconSize::SMALL));
        $buttonBar->addButton($reloadButton, ButtonBar::BUTTON_POSITION_RIGHT);
    }

    private function addShortCutButton(ButtonBar $buttonBar): void
    {
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setRouteIdentifier('blog_example')
            ->setDisplayName($this->getLanguageService()->sL('LLL:EXT:blog_example/Resources/Private/Language/locallang.xlf:administration.menu.index'));
        $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT);
    }

    protected function getLanguageService(): LanguageService
    {
        return $this->languageServiceFactory->createFromUserPreferences($GLOBALS['BE_USER']);
    }

    private function buildMenu(ModuleTemplate $view, string &$context): Menu
    {
        $menuItems = [
            'index' => [
                'controller' => 'Backend',
                'action' => 'index',
                'label' => $this->getLanguageService()->sL('LLL:EXT:blog_example/Resources/Private/Language/locallang.xlf:administration.menu.index'),
            ],
            'showAllComents' => [
                'controller' => 'Backend',
                'action' => 'showAllComments',
                'label' => $this->getLanguageService()->sL('LLL:EXT:blog_example/Resources/Private/Language/locallang.xlf:administration.menu.comments'),
            ],
        ];

        $menu = $view->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('BlogExampleModuleMenu');

        foreach ($menuItems as $menuItemConfig) {
            $isActive = $this->request->getControllerActionName() === $menuItemConfig['action'];
            $menuItem = $menu->makeMenuItem()
                ->setTitle($menuItemConfig['label'])
                ->setHref($this->uriBuilder->reset()->uriFor(
                    $menuItemConfig['action'],
                    [],
                    $menuItemConfig['controller'],
                ))
                ->setActive($isActive);
            $menu->addMenuItem($menuItem);
            if ($isActive) {
                $context = $menuItemConfig['label'];
            }
        }
        return $menu;
    }
}
