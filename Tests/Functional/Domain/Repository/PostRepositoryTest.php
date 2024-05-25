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

namespace T3docs\BlogExample\Tests\Functional\Domain\Repository;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PostRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        't3docs/blog-example',
    ];

    public function testFindAllRecords(): void
    {
        self::assertTrue(true);
    }
}
