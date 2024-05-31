<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Tests\Functional\ExpressionLanguage;

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
use T3docs\BlogExample\ExpressionLanguage\ExtensionConfigurationProvider;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class ExtensionConfigurationProviderTest extends FunctionalTestCase
{
    protected ExtensionConfigurationProvider $subject;

    protected array $testExtensionsToLoad = [
        't3docs/blog-example',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new ExtensionConfigurationProvider();
    }

    #[Test]
    public function extConfOfBlogExampleIsAvailableForExpressionLanguage(): void
    {
        $blogConfiguration = $this->subject->getExpressionLanguageVariables()['blogConfiguration'];

        self::assertIsArray(
            $blogConfiguration,
        );

        self::assertArrayHasKey(
            'foo',
            $blogConfiguration,
        );

        self::assertSame(
            'bar',
            $blogConfiguration['foo'],
        );
    }
}
