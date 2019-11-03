<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Unit\Support;

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

use Carbon\Carbon;
use LMS\Login\Support\InteractsWithTime;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class InteractsWithTimeTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /** @var InteractsWithTime */
    protected $trait;

    /**
     * Initialize Trait
     */
    public function setUp(): void
    {
        $this->trait = new class
        {
            use InteractsWithTime;
        };
    }

    /**
     * @test
     */
    public function availableIsCorrectWhenDelaySet(): void
    {
        $delay = 3;

        $availableAt = Carbon::now()->addMinutes($delay)->getTimestamp();

        $this->assertSame($this->trait->availableAt($delay), $availableAt);
    }
}
