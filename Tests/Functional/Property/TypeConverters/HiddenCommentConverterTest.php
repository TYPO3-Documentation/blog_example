<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Tests\Functional\Property\TypeConverters;

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
use T3docs\BlogExample\Domain\Model\Comment;
use T3docs\BlogExample\Property\TypeConverters\HiddenCommentConverter;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class HiddenCommentConverterTest extends FunctionalTestCase
{
    protected HiddenCommentConverter $subject;

    protected array $testExtensionsToLoad = [
        't3docs/blog-example',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/../../Fixtures/tx_blogexample_domain_model_comment.csv');

        // Init ConfigurationManagerInterface stateful singleton, usually done by extbase bootstrap
        $this->get(ConfigurationManagerInterface::class)->setRequest(
            (new ServerRequest())->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE),
        );

        // Must be called with "makeInstance", else the "inject" methods will not be called
        $this->subject = GeneralUtility::makeInstance(HiddenCommentConverter::class);
    }

    #[Test]
    public function fetchObjectFromPersistenceWillFindHiddenComment(): void
    {
        /** @var Comment $comment */
        $comment = $this->subject->convertFrom(2, Comment::class);

        self::assertInstanceOf(
            Comment::class,
            $comment,
        );

        self::assertSame(
            'Hidden Klaus',
            $comment->getAuthor(),
        );
    }
}
