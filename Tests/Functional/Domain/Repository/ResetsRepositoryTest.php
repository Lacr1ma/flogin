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

use LMS\Login\Domain\{Model\Resets, Repository\ResetsRepository};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ResetsRepositoryTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /** @var array */
    protected $testExtensionsToLoad = ['typo3conf/ext/login'];

    /** @var string */
    protected $fixturePathPrefix = __DIR__ . '/../../../Fixtures/Repository/';

    /** @var ResetsRepository */
    protected $repository;

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = ResetsRepository::make();

        $this->importDataSet($this->fixturePathPrefix . 'ResetsRepository.xml');
    }

    /**
     * Cleanup the repository
     */
    public function tearDown(): void
    {
        unset($this->repository);
    }

    /**
     * @test
     */
    public function exists(): void
    {
        $this->assertTrue(
            $this->repository->exists('secret')
        );
    }

    /**
     * @test
     */
    public function find(): void
    {
        $this->assertInstanceOf(
            Resets::class,
            $this->repository->find('secret')
        );

        $this->assertNull(
            $this->repository->find('bla')
        );
    }

    /**
     * @test
     */
    public function getExtensionKey(): void
    {
        $testMethod = new \ReflectionMethod(ResetsRepository::class, 'getExtensionKey');
        $testMethod->setAccessible(true);

        $result = $testMethod->invoke($this->repository);

        $this->assertSame('tx_login', $result);
    }
}
