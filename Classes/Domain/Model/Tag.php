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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A blog post tag
 */
final class Tag extends AbstractValueObject implements \Stringable
{
    #[Assert\NotBlank(message: 'Tag name must not be empty.')]
    public string $name = '';

    #[Assert\GreaterThan(value: 0, message: 'Priority must be greater than zero.')]
    public int $priority = 0;

    /**
     * Returns this tag as a formatted string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
