<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Tests\Unit;

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

use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @todo Remove this test as soon as first real unit test is added. Acts as placeholder.
 */
final class DummyTest extends UnitTestCase
{
    #[Test]
    public function dummyTest(): void
    {
        self::assertTrue(class_exists(Typo3Version::class));
    }
}
