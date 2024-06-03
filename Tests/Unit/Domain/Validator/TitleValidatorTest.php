<?php

declare(strict_types=1);

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

namespace T3docs\BlogExample\Tests\Unit\Domain\Validator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3docs\BlogExample\Domain\Validator\TitleValidator;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TitleValidatorTest extends UnitTestCase
{
    protected TitleValidator $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new TitleValidator();
    }

    #[Test]
    public function isValidWithInvalidTitleWillAddError(): void
    {
        $result = $this->subject->validate('_invalidTitle');

        self::assertTrue(
            $result->hasErrors(),
        );

        self::assertCount(
            1,
            $result->getErrors(),
        );
    }

    #[Test]
    #[DataProvider('valuesOfDifferentTypesWithoutErrorDataProvider')]
    public function isValidWithVariousTypesForTitleWillAddNoError(mixed $valueWithoutError): void
    {
        self::assertFalse(
            $this->subject->validate($valueWithoutError)->hasErrors(),
        );
    }

    public static function valuesOfDifferentTypesWithoutErrorDataProvider(): array
    {
        return [
            'Type string will not add error' => ['string'],
            'Type int will not add error' => [123],
            'Type bool (true) will not add error' => [true],
            'Type bool (false) will not add error' => [false],
            'Type float will not add error' => [1.23],
            'Type array will not add error' => [[0 => 'HuHu']],
            'Type object will not add error' => [new \stdClass()],
        ];
    }
}
