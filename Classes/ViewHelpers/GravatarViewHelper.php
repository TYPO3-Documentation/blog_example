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
 *     defaultImage="retro"
 *     alt="Gravator icon of {comment.author}"
 *     data-name="{comment.author}"  />
 * </code>
 * <output>
 * <img src="http://www.gravatar.com/avatar/4a28b782cade3dbcd6e306fa4757849d?d=retro&s=40" />
 * </output>
 */
final class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    protected $tagName = 'img';

    public function __construct(
        private readonly UriFactory $uriFactory,
    ) {
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'emailAddress',
            'string',
            'Email address used to generate the Gravatar hash',
            true,
        );

        $this->registerArgument(
            'defaultImage',
            'string',
            'Gravatar default image (mp, identicon, retro, monsterid, wavatar, robohash, blank)',
            false,
            'mp',
        );

        $this->registerArgument(
            'size',
            'int',
            'Size of the avatar in pixels',
            false,
            40,
        );
    }

    public function render(): string
    {
        $emailHash = $this->normalizeEmailToHash(
            (string)$this->arguments['emailAddress'],
        );

        $defaultImage = $this->normalizeDefaultImage(
            (string)$this->arguments['defaultImage'],
        );

        $size = $this->normalizeSize(
            (int)$this->arguments['size'],
        );

        $this->tag->addAttribute(
            'src',
            $this->buildGravatarUri($emailHash, $defaultImage, $size),
        );

        return $this->tag->render();
    }

    private function normalizeEmailToHash(string $email): string
    {
        return md5(strtolower(trim($email)));
    }

    private function normalizeDefaultImage(string $default): string
    {
        $allowed = [
            'mp',
            'identicon',
            'retro',
            'monsterid',
            'wavatar',
            'robohash',
            'blank',
        ];

        return in_array($default, $allowed, true) ? $default : 'mp';
    }

    private function normalizeSize(int $size): int
    {
        return MathUtility::forceIntegerInRange($size, 1, 2048);
    }

    private function buildGravatarUri(string $hash, string $default, int $size): string
    {
        return (string)$this->uriFactory
            ->createUri('https://www.gravatar.com/avatar/' . $hash)
            ->withQuery(
                HttpUtility::buildQueryString([
                    'd' => $default,
                    's' => $size,
                ]),
            );
    }
}
