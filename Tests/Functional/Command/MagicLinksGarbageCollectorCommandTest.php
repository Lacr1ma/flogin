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
use LMS\Flogin\Domain\{Model\Link, Repository\LinkRepository};
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class MagicLinksGarbageCollectorCommandTest extends FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/flogin', 'typo3conf/ext/routes'];

    /**
     * @test
     * @covers \LMS\Flogin\Command\MagicLinksGarbageCollectorCommand
     */
    public function execute(): void
    {
        $repository = $this->getContainer()->get(LinkRepository::class);

        $oneHourBack = (new DateTime())->modify('-1 hours');

        Link::create([
            'user' => 1,
            'token' => 'token',
            'crdate' => $oneHourBack->getTimestamp()
        ]);

        $oneHourFuture = (new DateTime())->modify('+1 hours');

        Link::create([
            'user' => 2,
            'token' => 'token',
            'crdate' => $oneHourFuture->getTimestamp()
        ]);

        $this->assertSame(1, count($repository->findExpired()));

        exec('/var/www/html/bin/typo3 login:magic-link_garbage');

        $this->assertSame(0, count($repository->findExpired()));
    }
}
