<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Unit\Hash;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use LMS\Flogin\Hash\Hash;
use TYPO3\CMS\Core\Crypto\{Random, PasswordHashing\PasswordHashInterface};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class HashTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * Initialize
     */
    protected function setUp(): void
    {
        $this->resetSingletonInstances = true;

        parent::setUp();
    }

    /**
     * @test
     */
    public function getRandom(): void
    {
        $testMethod = new \ReflectionMethod(Hash::class, 'getRandom');
        $testMethod->setAccessible(true);
        $result = $testMethod->invoke(new Hash());

        $this->assertInstanceOf(Random::class, $result);
    }

    /**
     * @test
     */
    public function getHashFactory(): void
    {
        $this->assertInstanceOf(
            PasswordHashInterface::class,
            Hash::getHashFactory()
        );
    }

    /**
     * @test
     */
    public function generate(): void
    {
        $plainPassword = 'secret';
        $encryptedPassword = Hash::encryptPassword($plainPassword);

        $this->assertTrue(
            Hash::checkPassword($plainPassword, $encryptedPassword)
        );
    }

    /**
     * @test
     */
    public function randomString(): void
    {
        $firstAttempt = Hash::randomString();
        $secondAttempt = Hash::randomString();

        $this->assertNotEmpty($firstAttempt);
        $this->assertNotEmpty($secondAttempt);
        $this->assertNotEquals($firstAttempt, $secondAttempt);
    }
}
