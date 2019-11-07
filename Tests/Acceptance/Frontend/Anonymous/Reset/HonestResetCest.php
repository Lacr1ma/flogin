<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Frontend\Anonymous\Reset;

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
class HonestResetCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function reset_link_clicked_and_reset_from_rendered(AcceptanceTester $I)
    {
        $I->wantTo('I follow <restore link> from my email and expect to see the <reset password form>.');

        $I->amOnResetPasswordPageRelatedTo(
            'dummy@example.com'
        );

        $I->seeElement('#password');
        $I->seeElement('#password-confirm');
        $I->seeElement('#change-password-link');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function reset_password_redirect_is_correct(AcceptanceTester $I)
    {
        $I->wantTo('After I change the password, I expect to be redirected to proper page.');

        $email = 'dummy@example.com';
        $password = 'password';

        $I->amChangingPassword($email, $password, $password);
        $I->see('The password has been updated!');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function notification_has_been_sent_after_password_reset(AcceptanceTester $I)
    {
        $I->wantTo('After my password has been changed, I expect to be notified by email.');

        $email = 'dummy@example.com';
        $password = $passwordConfirmation = 'password';

        $I->amChangingPassword($email, $password, $passwordConfirmation);

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Security Notice: Password has been changed');
        $I->seeInOpenedEmailRecipients('dummy@example.com');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function restore_password_link_in_email_works(AcceptanceTester $I)
    {
        $I->wantTo('I got <password updated> notification. I wanna be able to <restore> it back.');

        $email = 'dummy@example.com';
        $password = $passwordConfirmation = 'password';

        $I->amChangingPassword($email, $password, $passwordConfirmation);

        $I->amOnUrl(
            $I->extractLinkFromLastMail()
        );

        $I->seeElement('#email');

        $defaultEmail = $I->grabValueFrom('tx_login_login[email]');

        $I->assertSame($defaultEmail, $email);
    }
}
