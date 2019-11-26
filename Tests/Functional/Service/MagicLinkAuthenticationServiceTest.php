<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Service;

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

use LMS\Login\Service\MagicLinkAuthenticationService as AuthService;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class MagicLinkAuthenticationServiceTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/login'];

    /**
     * @test
     */
    public function simulation_allow(): void
    {
        $request = [
            'token' => 'valid'
        ];

        $_POST['tx_login_login'] = compact('request');

        $this->assertSame(
            AuthService::STATUS_AUTHENTICATION_SUCCESS,
            (new AuthService())->authUser([])
        );
    }

    /**
     * @test
     */
    public function simulation_continue(): void
    {
        $this->assertSame(
            AuthService::STATUS_AUTHENTICATION_CONTINUE,
            (new AuthService())->authUser([])
        );
    }
}