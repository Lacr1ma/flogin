<?php
/** @noinspection ALL */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Unit\Support\Domain\Property;

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

use DateTime;
use LMS\Flogin\Support\Domain\Property\Expirable;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ExpirableTest extends UnitTestCase
{
    /**
     * @var Expirable
     */
    protected $trait;

    /**
     * Initialize Trait
     */
    public function setUp(): void
    {
        $this->trait = new class {
            use Expirable;

            public static function getLifetimeInMinutes(): int
            {
                return 2;
            }
        };
    }

    /**
     * @test
     */
    public function lifeTimeIsCorrect(): void
    {
        $this->assertSame(2, $this->trait->getLifetimeInMinutes());
    }

    /**
     * @test
     */
    public function expirationTimeIsCorrect(): void
    {
        $time = time();
        $this->trait->setCrdate($time);

        $expirationTime = DateTime::createFromFormat('U', (string)$time);
        $expirationTime->modify("+2 minutes");

        $this->assertSame($expirationTime->getTimestamp(), $this->trait->getExpirationTime()->getTimestamp());
    }

    /**
     * @test
     */
    public function expiredWhenLifeTimeHasPassed(): void
    {
        $threeMinutesAgo = (new DateTime())->modify('-3 minutes')->getTimestamp();

        $this->trait->setCrdate($threeMinutesAgo);

        $this->assertTrue($this->trait->isExpired());
    }

    /**
     * @test
     */
    public function expiredWhenLifeTimeHasNotPassed(): void
    {
        $oneMinuteAgo = (new DateTime())->modify('-1 minutes')->getTimestamp();

        $this->trait->setCrdate($oneMinuteAgo);

        $this->assertFalse($this->trait->isExpired());
    }
}
