<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Tests\Functional;

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

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Provides shared configuration and setup for all extension
 * functional tests, which can still be extended for special
 * needs.
 */
abstract class ExtensionTestCase extends FunctionalTestCase
{
    public function __construct(string $name)
    {
        parent::__construct($name);

        // Shared core extensions to load
        $this->coreExtensionsToLoad = [
            ...array_values($this->coreExtensionsToLoad),
            'install',
        ];

        // Shared extension to load
        $this->testExtensionsToLoad = [
            ...array_values($this->testExtensionsToLoad),
            't3docs/blog-example',
        ];
    }
}
