<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Domain\Model\Request;

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
use LMS\Flogin\Domain\{Repository\UserRepository, Model\Request\ResetPasswordRequest};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ResetPasswordRequestTest extends BaseTest
{
    /**
     * @test
     */
    public function link_url_is_generated(): void
    {
        $user = $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user');

        $mock = $this->getAccessibleMock(ResetPasswordRequest::class, ['buildUrl'], [$user]);
        $mock
            ->expects($this->once())
            ->method('buildUrl')
            ->with('showResetForm', 'ResetPassword', ['request' => $mock]);

        $mock->_call('getUrl');
    }

    /**
     * @test
     */
    public function password_restore_link_expiration_interval_can_be_retrieved(): void
    {
        $request = new ResetPasswordRequest(
            $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user')
        );

        $this->assertSame(5, $request->getExpires());
    }
}
