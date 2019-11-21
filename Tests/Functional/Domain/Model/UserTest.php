<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Domain\Model;

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

use LMS\Login\Domain\Model\User;
use LMS\Login\Domain\Repository\UserRepository;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class UserTest extends \LMS\Login\Tests\Functional\BaseTest
{
//    /**
//     * @test
//     */
//    public function unlock_url_can_be_retrieved(): void
//    {
//        $user = UserRepository::make()->retrieveByUsername('user');
//
//        $mock = $this->getAccessibleMock(User::class, ['getUnlockActionUrl']);
//        $mock
//            ->expects($this->once())
//            ->method('buildUrl')
//            ->with('unlock', 'Locker', ['email' => $user->getEmail()]);
//
//        $mock->_call('getUnlockActionUrl');
//    }
//
//    /**
//     * @test
//     */
//    public function forgot_password_url_can_be_retrieved(): void
//    {
//        $user = UserRepository::make()->retrieveByUsername('user');
//
//        $mock = $this->getAccessibleMock(User::class, ['getForgotPasswordFormUrl']);
//        $mock
//            ->expects($this->once())
//            ->method('buildUrl')
//            ->with('showForgotForm', 'ForgotPassword', ['predefinedEmail' => $user->getEmail()]);
//
//        $mock->_call('getForgotPasswordFormUrl');
//    }
}
