<?php

declare(strict_types=1);

namespace T3docs\BlogExample\ViewHelpers;

use TYPO3\CMS\Core\Http\UriFactory;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

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
 * View helper for rendering gravatar images.
 * See http://www.gravatar.com
 * = Examples =
 * <code>
 * <blog:gravatar emailAddress="foo@bar.com"
 *     size="40"
 *     defaultImageUri="someDefaultImage"
 *     alt="Gravator icon of {comment.author}"
 *     data-name="{comment.author}"  />
 * </code>
 * <output>
 * <img src="http://www.gravatar.com/avatar/4a28b782cade3dbcd6e306fa4757849d?d=someDefaultImage&s=40" />
 * </output>
 */
class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'img';
    public function __construct(private readonly UriFactory $uriFactory)
    {
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        $this->registerArgument('emailAddress', 'string', '', true);
        $this->registerArgument('defaultImageUri', 'string', '');
        $this->registerArgument('size', 'int', '');
    }

    public function render(): string
    {
        $gravatarUri = $this->uriFactory->createUri(
            'https://gravatar.com/avatar/' . md5($this->arguments['emailAddress']),
        );

        $queryArguments = [];
        if ($this->arguments['defaultImageUri'] !== null) {
            $queryArguments['d'] = urlencode($this->arguments['defaultImageUri']);
        }

        if ($this->arguments['size'] !== null) {
            $queryArguments['s'] = MathUtility::forceIntegerInRange((int)$this->arguments['size'], 1, 2048);
        }

        $this->tag->addAttribute(
            'src',
            (string)$gravatarUri->withQuery(HttpUtility::buildQueryString($queryArguments, '', true)),
        );

        return $this->tag->render();
    }
}
