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

use PHPUnit\Framework\Attributes\Test;
use T3docs\BlogExample\ViewHelpers\GravatarViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class GravatarViewHelperTest extends FunctionalTestCase
{
    protected GravatarViewHelper $subject;

    protected array $testExtensionsToLoad = [
        't3docs/blog-example',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new GravatarViewHelper();
    }

    #[Test]
    public function renderWillBuildImgTagWithGravatarUri(): void
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource(sprintf(
            $this->getFluidTemplateSource(),
            '<blog:gravatar emailAddress="test" />',
        ));

        $content = $view->render();

        self::assertMatchesRegularExpression(
            '/https:\/\/gravatar\.com/',
            $content,
        );
    }

    #[Test]
    public function renderWillHashEmailAndAddItToImgTag(): void
    {
        $email = 'foo@example.com';

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource(sprintf(
            $this->getFluidTemplateSource(),
            '<blog:gravatar emailAddress="' . $email . '" />',
        ));

        $content = $view->render();

        self::assertStringContainsString(
            md5($email),
            $content,
        );
    }

    #[Test]
    public function renderWillEncodeDefaultImageUriToImgTag(): void
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource(sprintf(
            $this->getFluidTemplateSource(),
            '<blog:gravatar emailAddress="foo@example.com" defaultImageUri="https://typo3.org?test=123&foo=bar" />',
        ));

        $content = $view->render();

        self::assertMatchesRegularExpression(
            '/d=https%3A%2F%2Ftypo3.org%3Ftest%3D123%26foo%3Dbar/',
            $content,
        );
    }

    #[Test]
    public function renderWillAddSizeToGravatarUri(): void
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource(sprintf(
            $this->getFluidTemplateSource(),
            '<blog:gravatar emailAddress="foo@example.com" size="XXL" />',
        ));

        $content = $view->render();

        self::assertMatchesRegularExpression(
            '/s=1/',
            $content,
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
