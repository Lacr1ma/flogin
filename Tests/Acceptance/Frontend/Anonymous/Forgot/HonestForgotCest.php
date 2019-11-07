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
class HonestForgotCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function forgot_form_available(AcceptanceTester $I)
    {
        $I->wantTo('I am on <login> page, when i click on *forgot password* link, I wanna see <forgot password form>.');

        $I->amOnForgotPage();
    }

    /**
     * @param AcceptanceTester $I
     */
    public function forgot_form_contains_email(AcceptanceTester $I)
    {
        $I->wantTo('I expect to see <email> field in <forgot password form>.');

        $I->amOnForgotPage();

        $I->seeElement('#email');
        $I->seeElement('#send-reset-link');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function forgot_link_could_be_sent(AcceptanceTester $I)
    {
        $I->wantTo('I expect to receive the <forgot password link> after I submit <forgot password form> with my email.');

        $I->amRequestingPasswordResetNotification(
            'dummy@example.com'
        );

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Security Notice: Reset Password request');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function forgot_email_contains_proper_structure(AcceptanceTester $I)
    {
        $I->wantTo('When I open <forgot password link> notification, I expect to see the <restore> link inside');

        $I->amRequestingPasswordResetNotification(
            'dummy@example.com'
        );

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Security Notice: Reset Password request');
//        $I->seeInOpenedEmailBody('To reset your password please follow this link');
        $I->seeInOpenedEmailRecipients('dummy@example.com');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function redirect_after_forgot_submitted(AcceptanceTester $I)
    {
        $I->wantTo('When I submit <forgot password form>, I expect to be redirected to the proper page.');

        $I->amRequestingPasswordResetNotification(
            'dummy@example.com'
        );

        $I->see('Reset link has been sent to the user email address.');
    }
}
