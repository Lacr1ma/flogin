<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Domain\Repository;

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

use LMS\Flogin\Domain\Repository\ResetsRepository;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ResetsRepositoryTest extends \LMS\Flogin\Tests\Functional\BaseTest
{
    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/../../../Fixtures/Repository/ResetsRepository.xml');
    }

    /**
     * @test
     */
    public function reset_password_link_can_be_found(): void
    {
        $this->assertNotNull(
            ResetsRepository::make()->findExpired()
        );
    }

    /**
     * @test
     */
    public function exist_return_true_when_reset_password_link_persisted(): void
    {
        $this->assertTrue(
            ResetsRepository::make()->exists('secret')
        );
    }

    /**
     * @test
     */
    public function exist_return_false_when_reset_password_link_does_not_exist(): void
    {
        $this->assertFalse(
            ResetsRepository::make()->exists('invalid')
        );
    }

    /**
     * @test
     */
    public function find_returns_null_when_reset_password_link_is_not_found(): void
    {
        $this->assertNull(
            ResetsRepository::make()->find('invalid')
        );
    }

    /**
     * @test
     */
    public function magic_link_can_be_found(): void
    {
        $this->assertNotEmpty(
            ResetsRepository::make()->find('secret')
        );
    }

    /**
     * @test
     */
    public function extension_key_should_be_related_to_the_correct_scope(): void
    {
        $testMethod = new \ReflectionMethod(ResetsRepository::class, 'getExtensionKey');
        $testMethod->setAccessible(true);

        $this->assertSame('tx_flogin', $testMethod->invoke(ResetsRepository::make()));
    }
}
