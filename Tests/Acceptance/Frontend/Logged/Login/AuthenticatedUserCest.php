<?php
/** @noinspection PhpUnused */
/** @noinspection PhpRedundantOptionalArgumentInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Acceptance\Frontend\Logged\Login;

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

use LMS\Flogin\Tests\Acceptance\Support\AcceptanceTester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class AuthenticatedUserCest
{
    protected function login_and_go_to_logout_page(AcceptanceTester $I)
    {
        $I->amLoggedInAs('dummy');
        $I->moveBack();
    }

    /**
     * @before login_and_go_to_logout_page
     */
    protected function logout(AcceptanceTester $I)
    {
        $I->click('#logout-link');
    }

    /**
     * @before login_and_go_to_logout_page
     */
    public function logout_form_rendered(AcceptanceTester $I)
    {
        $I->wantTo('When I am logged in, I want to be able to logout. I must see <Logout> button.');

        $I->seeElement('#logout-link');
    }

    /**
     * @before logout
     */
    public function logout_redirect(AcceptanceTester $I)
    {
        $I->wantTo('I Click <Logout> and expect to be redirected to the proper page.');

        $I->seeInTitle('Logout');
    }

    /**
     * @before logout
     */
    public function login_possible(AcceptanceTester $I)
    {
        $I->wantTo('After I sign out, I am able to see the login form.');

        $I->amOnPage('/login');

        $I->seeElement('#login-button');
    }
}
