<?php

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

namespace T3docs\BlogExample\Tests\Unit\Domain\Model;

use T3docs\BlogExample\Domain\Model\Tag;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TagTest extends UnitTestCase
{
    public function testTagInitiallyReturnsEmptyString(): void
    {
        $subject = new Tag();

        self::assertSame(
            '',
            (string)$subject
        );
    }

    public function testTagReturnsValueFromConstructorArgument(): void
    {
        $subject = new Tag('TYPO3');

        self::assertSame(
            'TYPO3',
            (string)$subject
        );
    }

    public function testPriorityInitiallyReturnsZero(): void
    {
        $subject = new Tag();

        self::assertSame(
            0,
            $subject->priority
        );
    }
}
