<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Domain\Repository;

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

use LMS\Login\Domain\Repository\LinkRepository;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class LinkRepositoryTest extends \LMS\Login\Tests\Functional\BaseTest
{
    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/../../../Fixtures/Repository/LinkRepository.xml');
    }

    /**
     * @test
     */
    public function not_expired_link_for_user_can_be_found(): void
    {
        $this->assertNotNull(
            LinkRepository::make()->findActive(1)
        );
    }

    /**
     * @test
     */
    public function find_active_returns_an_empty_array_when_no_related_links_exist(): void
    {
        $this->assertEmpty(
            LinkRepository::make()->findActive(999)
        );
    }

    /**
     * @test
     */
    public function expired_magic_link_can_be_found(): void
    {
        $this->assertNotNull(
            LinkRepository::make()->findExpired()
        );
    }

    /**
     * @test
     */
    public function exist_return_true_when_magic_link_persisted(): void
    {
        $this->assertTrue(
            LinkRepository::make()->exists('secret')
        );
    }

    /**
     * @test
     */
    public function exist_return_false_when_magic_link_does_not_exist(): void
    {
        $this->assertFalse(
            LinkRepository::make()->exists('invalid')
        );
    }

    /**
     * @test
     */
    public function find_returns_null_when_magic_link_is_not_found(): void
    {
        $this->assertNull(
            LinkRepository::make()->find('invalid')
        );
    }

    /**
     * @test
     */
    public function magic_link_can_be_found(): void
    {
        $this->assertNotEmpty(
            LinkRepository::make()->find('secret')
        );
    }

    /**
     * @test
     */
    public function extension_key_should_be_related_to_the_correct_scope(): void
    {
        $testMethod = new \ReflectionMethod(LinkRepository::class, 'getExtensionKey');
        $testMethod->setAccessible(true);

        $this->assertSame('tx_login', $testMethod->invoke(LinkRepository::make()));
    }
}
