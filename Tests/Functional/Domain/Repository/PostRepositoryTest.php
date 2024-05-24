<?php

namespace T3docs\blog_example\Tests\Functional\Domain\Repository;

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
