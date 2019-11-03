<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Frontend;

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
    public function authenticated_returns_false_when_user_is_not_logged_in(AcceptanceTester $I)
    {
        $I->wantTo('I hit the api/user/authenticated endpoint and expect to see that I am not logged in.');

        $I->sendGET('user/authenticated');
        $I->seeResponseContainsJson(['authenticated' => false]);
    }

//    /**
//     * @param AcceptanceTester $I
//     */
//    public function authenticated_returns_true_when_user_is_not_logged_in(AcceptanceTester $I)
//    {
//        $I->amLoggedInAs('sergey', 'sergey');
//        $I->sendGET('user/authenticated');
//
//        $I->seeResponseContainsJson(['authenticated' => true]);
//    }

    /**
     * @param AcceptanceTester $I
     */
    public function user_info_denied_when_user_not_logged_in(AcceptanceTester $I)
    {
        $I->wantTo('I hit the api/user/current endpoint and expect to see my users data.');

        $I->sendGET('user/current');
        $I->canSeeResponseContains('Access denied');
    }

//    /**
//     * @param AcceptanceTester $I
//     */
//    public function user_info_present_when_user_authenticated(AcceptanceTester $I)
//    {
//        $I->amLoggedInAs('sergey', 'sergey');
//        $I->sendGET('user/current');
//
//        $I->canSeeResponseCodeIsSuccessful();
//    }
}
