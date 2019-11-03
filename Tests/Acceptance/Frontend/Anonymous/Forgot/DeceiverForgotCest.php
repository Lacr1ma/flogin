<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Frontend\Anonymous\Forgot;

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
class DeceiverForgotCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function forgot_form_shows_error_when_email_does_not_exist(AcceptanceTester $I)
    {
        $I->wantTo('When I submit <forgot password form> with invalid email, I see an error.');

        $I->amOnForgotPage();
        $I->fillField('tx_login_login[email]', 'dummy@domain.ltd');
        $I->click('#send-reset-link');

        $I->seeElement('.email-block > .is-invalid');
        $I->see('This email address is not connected to any user in our system.', '.email-is-invalid');
    }
}
