<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Domain\Validator\Login;

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

use LMS\Flogin\Domain\Validator\Login\UserNotLockedValidator;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class UserNotLockedValidatorTest extends \LMS\Flogin\Tests\Functional\BaseTest
{
    /**
     * @test
     */
    public function error_thrown_when_user_locked(): void
    {
        $username = 'locked';

        $this->initRequest($username, 'password');

        $validator = new UserNotLockedValidator();

        $this->assertTrue($validator->validate($username)->hasErrors());
    }

    /**
     * @test
     */
    public function validation_pass_when_username_invalid(): void
    {
        $username = 'invalid';

        $this->initRequest($username, 'password');

        $validator = new UserNotLockedValidator();

        $this->assertFalse($validator->validate($username)->hasErrors());
    }

    /**
     * @test
     */
    public function validation_pass_when_password_invalid(): void
    {
        $username = 'locked';

        $this->initRequest($username, 'invalid');

        $validator = new UserNotLockedValidator();

        $this->assertFalse($validator->validate($username)->hasErrors());
    }

    /**
     * @test
     */
    public function validation_pass_when_user_found_but_not_locked(): void
    {
        $username = 'user';

        $this->initRequest($username, 'password');

        $validator = new UserNotLockedValidator();

        $this->assertFalse($validator->validate($username)->hasErrors());
    }

    /**
     * @param string $username
     * @param string $password
     */
    private function initRequest(string $username, string $password): void
    {
        $_POST['tx_flogin_flogin'] = compact('username', 'password');
    }
}
