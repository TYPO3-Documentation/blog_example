<?php

namespace T3docs\blog_example\Tests\Functional\Domain\Repository;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PostRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'blog_example',
    ];

    protected array $coreExtensionsToLoad = [
        'install',
    ];
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFindAllRecords(): void
    {
        self::assertTrue(true);
    }
}
