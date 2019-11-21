<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Domain\Model\Request;

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

use LMS\Login\Domain\{Repository\UserRepository, Model\Request\MagicLinkRequest};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class MagicLinkRequestTest extends \LMS\Login\Tests\Functional\BaseTest
{
    /**
     * @test
     */
    public function notification_fired(): void
    {
        $user = UserRepository::make()->retrieveByUsername('user');

        $mock = $this->getAccessibleMock(MagicLinkRequest::class, ['fireSendMagicLinkEvent'], [$user]);
        $mock
            ->expects($this->once())
            ->method('fireSendMagicLinkEvent')
            ->with($mock);

        $mock->_call('notify');
    }

    /**
     * @test
     */
    public function link_url_is_generated(): void
    {
        $user = UserRepository::make()->retrieveByUsername('user');

        $mock = $this->getAccessibleMock(MagicLinkRequest::class, ['buildUrl'], [$user]);
        $mock
            ->expects($this->once())
            ->method('buildUrl')
            ->with('login', 'MagicLink', ['request' => $mock]);

        $mock->_call('getUrl');
    }

    /**
     * @test
     */
    public function magic_link_expiration_interval_can_be_retrieved(): void
    {
        $request = new MagicLinkRequest(
            UserRepository::make()->retrieveByUsername('user')
        );

        $this->assertSame(6, $request->getExpires());
    }
}
