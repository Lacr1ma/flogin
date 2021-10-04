<?php
/** @noinspection PhpExpressionResultUnusedInspection */
/** @noinspection PhpRedundantOptionalArgumentInspection */

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
use LMS\Flogin\Support\Domain\Property\Locked;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class LockedTest extends UnitTestCase
{
    /**
     * @var Locked
     */
    protected $trait;

    /**
     * Initialize Trait
     */
    public function setUp(): void
    {
        $this->trait = new class
        {
            use Locked;

            public static function getLockMinutesInterval(): int
            {
                return 2;
            }
        };
    }

    /**
     * @test
     */
    public function mutatorWorksProperly(): void
    {
        $this->trait->setLocked(false);

        $this->trait->isLocked();

        $this->assertFalse($this->trait->isLocked());
        $this->assertTrue($this->trait->isNotLocked());
    }

    /**
     * @test
     */
    public function checkUnlockTime(): void
    {
        $time = time();
        $this->trait->setTstamp($time);

        $unlockTime = DateTime::createFromFormat('U', (string)$time);
        $unlockTime->modify("+2 minutes");

        $this->assertSame($unlockTime->getTimestamp(), $this->trait->getUnlockTime()->getTimestamp());
    }

    /**
     * @test
     */
    public function lockIntervalTimeHasPassed(): void
    {
        $threeMinutesAgo = new DateTime();
        $threeMinutesAgo->modify("-3 minutes");

        $this->trait->setTstamp($threeMinutesAgo->getTimestamp());

        $this->assertTrue($this->trait->isTimeToUnlock());
    }

    /**
     * @test
     */
    public function lockIntervalTimeNotPassed(): void
    {
        $oneMinutesAgo = new DateTime();
        $oneMinutesAgo->modify("-1 minutes");

        $this->trait->setTstamp($oneMinutesAgo->getTimestamp());

        $this->assertFalse($this->trait->isTimeToUnlock());
    }
}
