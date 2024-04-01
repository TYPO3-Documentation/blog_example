<?php

declare(strict_types=1);

namespace T3docs\BlogExample\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

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
 * page title provider class for blog post index and detail view
 */
final class BlogPageTitleProvider extends AbstractPageTitleProvider
{
    protected string $title = '';

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
