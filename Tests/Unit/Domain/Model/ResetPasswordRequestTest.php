<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Unit\Domain\Model;

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

use LMS\Login\Domain\Model\Request\ResetPasswordRequest;
use LMS\Login\Domain\Model\User;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ResetPasswordRequestTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * Initialize
     */
    protected function setUp(): void
    {
        $this->resetSingletonInstances = true;

        parent::setUp();
    }

    /**
     * @test
     */
    public function ensureInitializationWorks(): void
    {
        $request = new ResetPasswordRequest(new User());

        $this->assertNotEmpty($request->getToken());
        $this->assertNotEmpty($request->getUser());
        $this->assertEmpty($request->getPassword());
        $this->assertEmpty($request->getPasswordConfirmation());
    }

    /**
     * @test
     */
    public function isConfirmationMatching(): void
    {
        $request = new ResetPasswordRequest(new User());

        $this->assertFalse($request->isConfirmationMatching());

        $request->setPassword('secret');
        $request->setPasswordConfirmation('secret');

        $this->assertTrue($request->isConfirmationMatching());
    }
}
