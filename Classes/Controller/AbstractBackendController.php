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

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Abstract base controller for the BlogExample extension
 */
abstract class AbstractBackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    protected int $pageUid = 0;

    /**
     * Function will be called before every other action
     */
    protected function initializeAction()
    {
        $this->pageUid = (int)($this->request->getQueryParams()['id'] ?? 0);
        parent::initializeAction();
    }

    /**
     * Generates the action menu
     */
    protected function initializeModuleTemplate(ServerRequestInterface $request): ModuleTemplate
    {
        $menuItems = [
            'index' => [
                'controller' => 'BackendBlogController',
                'action' => 'index',
                'label' => $GLOBALS['LANG']->sL('LLL:EXT:indexed_search/Resources/Private/Language/locallang.xlf:administration.menu.general'),
            ],
            'pages' => [
                'controller' => 'BackendBlogController',
                'action' => 'pages',
                'label' => $GLOBALS['LANG']->sL('LLL:EXT:indexed_search/Resources/Private/Language/locallang.xlf:administration.menu.pages'),
            ],
            'externalDocuments' => [
                'controller' => 'BackendBlogController',
                'action' => 'externalDocuments',
                'label' => $GLOBALS['LANG']->sL('LLL:EXT:indexed_search/Resources/Private/Language/locallang.xlf:administration.menu.externalDocuments'),
            ],
            'statistic' => [
                'controller' => 'BackendBlogController',
                'action' => 'statistic',
                'label' => $GLOBALS['LANG']->sL('LLL:EXT:indexed_search/Resources/Private/Language/locallang.xlf:administration.menu.statistic'),
            ],
        ];

        $view = $this->moduleTemplateFactory->create($request);

        $menu = $view->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('IndexedSearchModuleMenu');

        $context = '';
        foreach ($menuItems as $menuItemConfig) {
            $isActive = $this->request->getControllerActionName() === $menuItemConfig['action'];
            $menuItem = $menu->makeMenuItem()
                ->setTitle($menuItemConfig['label'])
                ->setHref($this->uriBuilder->reset()->uriFor($menuItemConfig['action'], [], $menuItemConfig['controller']))
                ->setActive($isActive);
            $menu->addMenuItem($menuItem);
            if ($isActive) {
                $context = $menuItemConfig['label'];
            }
        }

        $view->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
        $view->setTitle(
            $GLOBALS['LANG']->sL('LLL:EXT:indexed_search/Resources/Private/Language/locallang_mod.xlf:mlang_tabs_tab'),
            $context
        );

        $permissionClause = $GLOBALS['BE_USER']->getPagePermsClause(Permission::PAGE_SHOW);
        $pageRecord = BackendUtility::readPageAccess($this->pageUid, $permissionClause);
        if ($pageRecord) {
            $view->getDocHeaderComponent()->setMetaInformation($pageRecord);
        }
        $view->setFlashMessageQueue($this->getFlashMessageQueue());

        return $view;
    }

}
