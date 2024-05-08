<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/**
 * A blog post tag
 */
final class Tag extends AbstractValueObject implements \Stringable
{
    public int $priority = 0;

    public function __construct(public string $name = '') {}

    /**
     * Returns this tag as a formatted string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
