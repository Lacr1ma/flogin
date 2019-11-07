<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Frontend\Anonymous\Login;

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
class HonestLoginCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function login_form_available(AcceptanceTester $I)
    {
        $I->wantTo('I see the sign in form, so i can be authenticated.');

        $I->amOnPage('/login');

        $I->seeElement('#username-field');
        $I->seeElement('#password-field');
        $I->seeElement('#remember-check');
        $I->seeElement('#forgot-link');
        $I->seeElement('#magic-link');
        $I->seeElement('#login-button');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function redirect_arises(AcceptanceTester $I)
    {
        $I->wantTo('I submit sign in form with proper credentials and expect to be redirected to a proper page.');

        $I->amLoggedInAs();

        $I->see('You should see that after login process');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function email_is_send_after_login(AcceptanceTester $I)
    {
        $I->wantTo('I want to be notified, when someone logged in to my account.');

        $I->amLoggedInAs();

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Security Notice: Someone has logged in to your account.');
        $I->seeInOpenedEmailRecipients('dummy@example.com');
    }
}
