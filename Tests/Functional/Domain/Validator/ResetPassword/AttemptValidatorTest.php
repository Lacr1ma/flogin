<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Domain\Validator\ResetPassword;

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
use LMS\Flogin\Tests\Functional\BaseTest;
use LMS\Flogin\Domain\Repository\UserRepository;
use LMS\Flogin\Domain\Validator\ResetPassword\AttemptValidator;
use LMS\Flogin\Domain\Model\{Resets, Request\ResetPasswordRequest};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class AttemptValidatorTest extends BaseTest
{
    /**
     * @test
     */
    public function pass_when_password_match(): void
    {
        $request = new ResetPasswordRequest(
            $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user')
        );

        $request->setPassword('secret');
        $request->setPasswordConfirmation('secret');

        Resets::create([
            'pid' => 0,
            'token' => $request->getToken(),
            'user' => $request->getUser()->getUid(),
            'crdate' => Carbon::now()->addHour()->timestamp
        ]);

        $this->assertFalse(
            (new AttemptValidator())->validate($request)->hasErrors()
        );
    }

    /**
     * @test
     */
    public function fail_when_password_does_not_match(): void
    {
        $request = new ResetPasswordRequest(
            $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user')
        );

        $request->setPassword('secret');
        $request->setPasswordConfirmation('invalid');

        Resets::create([
            'pid' => 0,
            'token' => $request->getToken(),
            'user' => $request->getUser()->getUid(),
            'crdate' => Carbon::now()->addHour()->timestamp
        ]);

        $this->assertTrue(
            (new AttemptValidator())->validate($request)->hasErrors()
        );
    }
}
