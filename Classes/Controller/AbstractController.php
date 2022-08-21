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

use FriendsOfTYPO3\BlogExample\Exception\NoBlogAdminAccessException;
use phpDocumentor\Reflection\Types\Boolean;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Abstract base controller for the BlogExample extension
 */
abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Override getErrorFlashMessage to present
     * nice flash error messages.
     */
    protected function getErrorFlashMessage(): string
    {
        $defaultFlashMessage = parent::getErrorFlashMessage();
        $locallangKey = sprintf(
            'error.%s.%s',
            $this->request->getControllerName(),
            $this->actionMethodName
        );
        return $this->translate($locallangKey, $defaultFlashMessage);
    }

    protected function hasBlogAdminAccess(): boolean
    {
        // TODO access protection
        return true;
    }

    /**
     * @throws NoBlogAdminAccessException
     */
    protected function checkBlogAdminAccess()
    {
        if (!$this->hasBlogAdminAccess()) {
            throw new NoBlogAdminAccessException();
        }
    }

    /**
     * helper function to render localized flashmessages
     */
    public function addLocalizedFlashMessage(
        string $action,
        ContextualFeedbackSeverity $severity = ContextualFeedbackSeverity::OK
    ): void {
        $messageLocallangKey = sprintf(
            'flashmessage.%s.%s',
            $this->request->getControllerName(),
            $action
        );
        $localizedMessage = $this->translate(
            $messageLocallangKey,
            '[' . $messageLocallangKey . ']'
        );
        $titleLocallangKey = sprintf('%s.title', $messageLocallangKey);
        $localizedTitle = $this->translate(
            $titleLocallangKey,
            '[' . $titleLocallangKey . ']'
        );
        $this->addFlashMessage($localizedMessage, $localizedTitle, $severity);
    }

    /**
     * helper function to use localized strings in BlogExample controllers
     */
    protected function translate(
        string $key,
        string $defaultMessage = ''
    ): string {
        $message = LocalizationUtility::translate($key, 'BlogExample');
        if ($message === null) {
            $message = $defaultMessage;
        }
        return $message;
    }
}
