<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Domain\Repository;

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

use LMS\Flogin\Domain\Repository\UserRepository;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class UserRepositoryTest extends \LMS\Flogin\Tests\Functional\BaseTest
{
    /**
     * @test
     */
    public function can_be_found_by_username(): void
    {
        $this->assertNotNull(
            UserRepository::make()->retrieveByUsername('user')
        );
    }

    /**
     * @test
     */
    public function find_by_username_returns_null_when_user_not_found(): void
    {
        $this->assertNull(
            UserRepository::make()->retrieveByUsername('invalid')
        );
    }

    /**
     * @test
     */
    public function current_user_returns_null_when_user_is_not_logged_in(): void
    {
        $this->assertNull(
            UserRepository::make()->current()
        );
    }

    /**
     * @test
     */
    public function current_user_can_be_retrieved(): void
    {
        $GLOBALS['TSFE']->fe_user->user['uid'] = 1;

        $this->assertNotNull(
            UserRepository::make()->current()
        );
    }

    /**
     * @test
     */
    public function can_be_found_by_email(): void
    {
        $this->assertNotNull(
            UserRepository::make()->retrieveByEmail('user@example.com')
        );
    }

    /**
     * @test
     */
    public function cant_be_found_by_email_when_invalid(): void
    {
        $this->assertNull(
            UserRepository::make()->retrieveByEmail('invalid@example.com')
        );
    }

    /**
     * @test
     */
    public function locked_user_can_be_found(): void
    {
        $this->assertNotEmpty(
            UserRepository::make()->findLocked()->all()
        );
    }
}
