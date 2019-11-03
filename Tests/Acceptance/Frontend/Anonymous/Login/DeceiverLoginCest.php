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
class DeceiverLoginCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function login_and_password_required(AcceptanceTester $I)
    {
        $I->wantTo('I see error messages when I am trying to sing in with invalid credentials.');

        $username = $password = bin2hex(random_bytes(5));

        $I->amLoggedInAs($username, $password);

        $I->seeElement('.username-block > .is-invalid');
        $I->see('Provided username is not found.', '.username-is-invalid');

        $I->seeElement('.password-block > .is-invalid');
        $I->see('Password is invalid', '.password-is-invalid');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function username_error_is_not_visible_when_user_exists(AcceptanceTester $I)
    {
        $I->wantTo('I submit sign in form with existing <user>, but invalid password. I expect to see  password error only.');

        $password = bin2hex(random_bytes(5));

        $I->amLoggedInAs('sergey', $password);

        $I->dontSeeElement('.username-block > .is-invalid');
        $I->dontSeeElement('.username-is-invalid');

        $I->seeElement('.password-block > .is-invalid');
        $I->see('Password is invalid', '.password-is-invalid');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function throttling_check(AcceptanceTester $I)
    {
        $I->wantTo('I wanna be blocked when trying to send too much requests from the same IP address.');

        $username = $password = bin2hex(random_bytes(5));

        foreach (range(0, 4) as $index) {
            $I->amLoggedInAs('sergey', $password);
        }

        $I->seeElement('.alert-danger');

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Security Notice: Account has been locked');
        $I->seeInOpenedEmailRecipients('borulkosergey@icloud.com');
    }

    /**
     * @param AcceptanceTester $I
     *
     * @depends throttling_check
     */
    public function user_can_be_unlocked(AcceptanceTester $I)
    {
        $I->wantTo('When my user is locked, I expect to be unlocked after following the <unlockUrl> that i grab from email.');

        $unlockPage = $I->extractLinkFromLastMail();
        $I->amOnUrl($unlockPage);

        $I->see('User has been successfully unlocked!');
    }
}
