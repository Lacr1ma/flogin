<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Api;

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

use LMS\Login\Tests\Acceptance\Support\AcceptanceTester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ApiCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function user_info_present_when_user_authenticated(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726da');
        $I->haveHttpHeader('X-CSRF-TOKEN', '53574eb0bafe1c0a4d8a2cfc0cf726da');

        $I->sendGET('user/current');

        $I->seeResponseContainsJson(['email' => 'user@example.com']);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function proper_hash_is_required_for_account_creation(AcceptanceTester $I)
    {
        $I->wantTo('I want to be redirected to the error page, when I try to create temporary user using invalid link.');

        $I->sendGET('user/one-time-account/invalid-hash');

        $I->seeResponseContains('Account hash does not exist');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function authenticated_returns_false_when_user_not_logged_in(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendGET('user/authenticated');

        $I->seeResponseContainsJson(['authenticated' => false]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function authenticated_returns_true_when_user_logged_in(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Cookie', 'fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726da');
        $I->haveHttpHeader('X-CSRF-TOKEN', '53574eb0bafe1c0a4d8a2cfc0cf726da');
        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendGET('user/authenticated');

        $I->seeResponseContainsJson(['authenticated' => true]);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function backend_user_session_required_for_simulate(AcceptanceTester $I)
    {
        $I->wantTo('When I want to simulate another FE user connection, I need to have an active BE session.');

        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendGET('user/simulate/user-name');

        $I->seeResponseCodeIs(403);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function backend_user_session_required_for_terminate(AcceptanceTester $I)
    {
        $I->wantTo('When I want to delete another FE user active sessions, I need to have an active BE session.');

        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendGET('user/terminate/2');

        $I->seeResponseCodeIs(403);
    }
}
