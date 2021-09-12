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

use LMS\Flogin\Tests\Functional\BaseTest;
use LMS\Flogin\Domain\Validator\Login\UsernameValidator;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class UsernameValidatorTest extends BaseTest
{
    /**
     * @test
     */
    public function error_thrown_when_too_many_attempts(): void
    {
        $username = 'invalid';

        $_POST['tx_flogin_flogin'] = ['username' => $username];

        $validator = new UsernameValidator();

        $this->assertTrue($validator->validate($username)->hasErrors());
    }

    /**
     * @test
     */
    public function pass_when_username_exists(): void
    {
        $username = 'user';

        $_POST['tx_flogin_flogin'] = ['username' => $username];

        $validator = new UsernameValidator();

        $this->assertFalse($validator->validate($username)->hasErrors());
    }
}
