<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Tests\Functional\ViewHelpers;

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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3docs\BlogExample\ViewHelpers\GravatarViewHelper;
use TYPO3\CMS\Core\Http\UriFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;

class GravatarViewHelperTest extends FunctionalTestCase
{
    protected GravatarViewHelper $subject;

    protected array $testExtensionsToLoad = [
        't3docs/blog-example',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new GravatarViewHelper(GeneralUtility::makeInstance(UriFactory::class));
    }

    public static function renderDataProvider(): array
    {
        return [
            'renderWillHashEmailAndAddItToImgTag' => [
                '<blog:gravatar emailAddress="foo@example.org" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d" />',
            ],
            'renderWillEncodeDefaultImageUriToImgTag' => [
                '<blog:gravatar emailAddress="foo@example.org" defaultImageUri="https://typo3.org?test=123&foo=bar" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?d=https%253A%252F%252Ftypo3.org%253Ftest%253D123%2526foo%253Dbar" />',
            ],
            'renderWithCombinedSizeAndDefaultImageUri' => [
                '<blog:gravatar emailAddress="foo@example.org" size="256" defaultImageUri="https://typo3.org" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?d=https%253A%252F%252Ftypo3.org&amp;s=256" />',
            ],
            'renderWithCombinedSizeAndEmptyDefaultImageUriWillOnlyAddSizeArgument' => [
                '<blog:gravatar emailAddress="foo@example.org" size="512" defaultImageUri="" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?s=512" />',
            ],
            'renderWithStringForSizeWillCastValueToIntAndForceValueTo1' => [
                '<blog:gravatar emailAddress="foo@example.org" size="XXL" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?s=1" />',
            ],
            'renderWithTooSmallIntForSizeWillBeForcedTo1' => [
                '<blog:gravatar emailAddress="foo@example.org" size="-12" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?s=1" />',
            ],
            'renderWithIntForSizeWillStayTheSame' => [
                '<blog:gravatar emailAddress="foo@example.org" size="120" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?s=120" />',
            ],
            'renderWithTooHighSizeWillForceValueTo2048' => [
                '<blog:gravatar emailAddress="foo@example.org" size="217348" />',
                '<img src="https://gravatar.com/avatar/64f677e30cd713a9467794a26711e42d?s=2048" />',
            ],
        ];
    }

    #[DataProvider('renderDataProvider')]
    #[Test]
    public function render(string $templateSource, string $expected): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(sprintf(
            $this->getFluidTemplateSource(),
            $templateSource,
        ));

        self::assertSame(
            $expected,
            (new TemplateView($context))->render(),
        );
    }

    private function getFluidTemplateSource(): string
    {
        return '<html lang="en"
            xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
            xmlns:blog="http://typo3.org/ns/T3docs/BlogExample/ViewHelpers"
            data-namespace-typo3-fluid="true">%s</html>';
    }
}
