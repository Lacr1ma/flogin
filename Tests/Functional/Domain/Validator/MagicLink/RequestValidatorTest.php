<?php
/** @noinspection PhpInternalEntityUsedInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Domain\Validator\MagicLink;

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

use DateTime;
use LMS\Flogin\Tests\Functional\BaseTest;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use LMS\Flogin\Domain\Validator\MagicLink\RequestValidator;
use LMS\Flogin\Domain\Model\{Link, Request\MagicLinkRequest};
use LMS\Flogin\Domain\Repository\{LinkRepository, UserRepository};

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class RequestValidatorTest extends BaseTest
{
    /**
     * @test
     */
    public function redirect_to_token_not_found(): void
    {
        $request = new MagicLinkRequest(
            $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user')
        );

        $this->expectException(PropagateResponseException::class);

        (new RequestValidator())->validate($request);
    }

    /**
     * @test
     */
    public function redirect_to_token_expired(): void
    {
        $request = new MagicLinkRequest(
            $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user')
        );

        $oneHourBack = (new DateTime())->modify('-1 hours');

        Link::create([
            'pid' => 0,
            'token' => $request->getToken(),
            'user' => $request->getUser()->getUid(),
            'crdate' => $oneHourBack->getTimestamp()
        ]);

        $this->expectException(PropagateResponseException::class);

        (new RequestValidator())->validate($request);
    }

    /**
     * @test
     */
    public function link_deleted_when_request_is_valid(): void
    {
        $request = new MagicLinkRequest(
            $this->getContainer()->get(UserRepository::class)->retrieveByUsername('user')
        );

        $oneHourFuture = (new DateTime())->modify('+1 hours');

        Link::create([
            'pid' => 0,
            'token' => $request->getToken(),
            'user' => $request->getUser()->getUid(),
            'crdate' => $oneHourFuture->getTimestamp()
        ]);

        (new RequestValidator())->validate($request);

        $this->assertNull(
            $this->getContainer()->get(LinkRepository::class)->find($request->getToken())
        );
    }
}
