<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Command;

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
use LMS\Login\Domain\{Model\Resets, Repository\ResetsRepository};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ResetGarbageCollectorCommandTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/login'];

    /**
     * @test
     * @covers \LMS\Login\Command\ResetGarbageCollectorCommand
     */
    public function execute(): void
    {
        $repository = ResetsRepository::make();

        Resets::create([
            'user' => 1,
            'token' => 1,
            'crdate' => Carbon::now()->subHour()->timestamp
        ]);

        Resets::create([
            'user' => 2,
            'token' => 2,
            'crdate' => Carbon::now()->addHour()->timestamp
        ]);

        $this->assertSame(1, $repository->findExpired()->count());

        exec('/var/www/html/bin/typo3 login:password-link_garbage');

        $this->assertSame(0, $repository->findExpired()->count());
    }
}
