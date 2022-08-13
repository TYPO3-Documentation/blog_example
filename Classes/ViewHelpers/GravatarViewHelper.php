<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

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
 * <blog:gravatar emailAddress="foo@bar.com" size="40" defaultImageUri="someDefaultImage" />
 * </code>
 * <output>
 * <img src="http://www.gravatar.com/avatar/4a28b782cade3dbcd6e306fa4757849d?d=someDefaultImage&s=40" />
 * </output>
 */
class GravatarViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{

    use CompileWithRenderStatic;

    /**
     * @var string
     */
    protected $tagName = 'img';

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerUniversalTagAttributes();
        $this->registerArgument('emailAddress', 'string', '', true)
            ->registerArgument('defaultImageUri', 'string', '', false)
            ->registerArgument('size', 'string', '', false);
    }

    /**
     * Render the gravatar image
     *
     * @return string The rendered image tag
     */
    public function render()
    {
        $gravatarUri = 'http://www.gravatar.com/avatar/' . md5($this->arguments['emailAddress']);
        $uriParts = [];
        if ($this->arguments['defaultImageUri'] !== null) {
            $uriParts[] = 'd=' . urlencode($this->arguments['defaultImageUri']);
        }
        if ($this->arguments['size'] !== null) {
            $uriParts[] = 's=' . urlencode($this->arguments['size']);
        }
        if (count($uriParts) > 0) {
            $gravatarUri .= '?' . implode('&', $uriParts);
        }

        $this->tag->addAttribute('src', $gravatarUri);
        return $this->tag->render();
    }
}
