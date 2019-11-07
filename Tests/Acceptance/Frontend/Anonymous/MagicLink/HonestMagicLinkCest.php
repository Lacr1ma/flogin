<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Frontend\Anonymous\MagicLink;

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
class HonestMagicLinkCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function magic_link_form_available(AcceptanceTester $I)
    {
        $I->wantTo('I am on <login> page, when i click on *login by magic link*, I wanna see <magic link form>.');

        $I->amOnMagicLinkPage();
    }

    /**
     * @param AcceptanceTester $I
     */
    public function magic_link_form_contains_email(AcceptanceTester $I)
    {
        $I->wantTo('I expect to see <email> field in <magic link form>.');

        $I->amOnMagicLinkPage();

        $I->seeElement('#email');
        $I->seeElement('#send-magic-link');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function magic_link_could_be_sent(AcceptanceTester $I)
    {
        $I->wantTo('I expect to receive the <magic link> after I submit <magic link form> with my email.');

        $I->amRequestingMagicLinkNotification(
            'dummy@example.com'
        );

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Sign in via magic link');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function magic_email_contains_proper_structure(AcceptanceTester $I)
    {
        $I->wantTo('When I open <magic link> notification, I expect to see the <sign in> link inside');

        $I->amRequestingMagicLinkNotification(
            'dummy@example.com'
        );

        $I->fetchEmails();
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject('Sign in via magic link');
//        $I->seeInOpenedEmailBody('To reset your password please follow this link');
        $I->seeInOpenedEmailRecipients('dummy@example.com');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function redirect_after_magic_link_submit_is_correct(AcceptanceTester $I)
    {
        $I->wantTo('When I submit <magic link form>, I expect to be redirected to a proper page.');

        $I->amRequestingMagicLinkNotification(
            'dummy@example.com'
        );

        $I->seeInTitle('Email sent');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function magic_link_in_email_works(AcceptanceTester $I)
    {
        $I->wantTo('When I follow <magic link> from notification, I expect to be logged in and be redirected to <afterLoginPage>.');

        $I->amRequestingMagicLinkNotification(
            'dummy@example.com'
        );

        $I->amOnUrl(
            $I->extractLinkFromLastMail()
        );

        $I->seeInTitle('Catalog');
    }
}
