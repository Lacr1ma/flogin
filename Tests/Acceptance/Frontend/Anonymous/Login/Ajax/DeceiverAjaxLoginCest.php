<?php
/** @noinspection PhpUnused */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Acceptance\Frontend\Anonymous\Login\Ajax;

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
class DeceiverAjaxLoginCest
{
    public function login_and_password_required(AcceptanceTester $I)
    {
        $I->wantTo('I see the error messages when I am trying to login with invalid credentials.');

        $username = $password = bin2hex(random_bytes(5));

        $I->amLoggedByAjaxFormAs($username, $password);

        $I->waitForElement('.username-block > .is-invalid');
        $I->see('Provided username is not found.', '.username-is-invalid');

        $I->waitForElement('.password-block > .is-invalid');
        $I->see('Password is invalid', '.password-is-invalid');
    }

    public function username_error_is_not_visible_when_user_exists(AcceptanceTester $I)
    {
        $I->wantTo('I submit sign in form with existing <user>, but invalid password. I expect to see  password error only.');

        $password = bin2hex(random_bytes(5));

        $I->amLoggedByAjaxFormAs('dummy', $password);

        $I->dontSeeElement('.username-block > .is-invalid');
        $I->dontSeeElement('.username-is-invalid');

        $I->waitForElement('.password-block > .is-invalid');
        $I->see('Password is invalid', '.password-is-invalid');
    }

    public function user_can_be_logged_in(AcceptanceTester $I)
    {
        $I->wantTo('I can login using ajax form.');

        $I->amLoggedByAjaxFormAs('dummy');

        $I->waitForElement('#login_success_block');
    }
}
