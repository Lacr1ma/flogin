<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Command;

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
use LMS\Flogin\Domain\{Model\User, Repository\UserRepository};
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class OnetimeAccountGarbageCollectorCommandTest extends FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/flogin'];

    /**
     * @test
     * @covers \LMS\Flogin\Command\OnetimeAccountGarbageCollectorCommand
     */
    public function execute(): void
    {
        $repository = $this->getContainer()->get(UserRepository::class);

        $endTime = (new DateTime())->modify('-1 seconds');

        User::create([
            'username' => 'temp',
            'endtime' => $endTime->getTimestamp()
        ]);

        $beforeCount = $repository->countAll();

        exec('/var/www/html/bin/typo3 login:onetime-user_garbage');

        $this->assertNotEquals($beforeCount, $repository->countAll());
    }
}
