<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Service;

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

use LMS\Flogin\Service\BackendSimulationAuthenticationService as Simulator;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class BackendSimulationAuthenticationServiceTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/flogin'];

    /**
     * @test
     */
    public function simulation_allow(): void
    {
        $_POST['be_user']['ses_id'] = $GLOBALS['BE_USER']->id = 'my_session_hash';

        $this->assertSame(
            Simulator::STATUS_AUTHENTICATION_SUCCESS,
            (new Simulator())->authUser([])
        );
    }

    /**
     * @test
     */
    public function simulation_continue(): void
    {
        $_POST['be_user']['ses_id'] = 'invalid';

        $this->assertSame(
            Simulator::STATUS_AUTHENTICATION_CONTINUE,
            (new Simulator())->authUser([])
        );
    }
}
