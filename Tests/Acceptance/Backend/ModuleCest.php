<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Backend;

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

use LMS\Login\Tests\Acceptance\Support\BackendTester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ModuleCest
{
    /**
     * @param BackendTester $I
     */
    public function _before(BackendTester $I)
    {
        $I->useExistingSession('admin');

        $I->click('LMS: Login', '#web_LoginLogin');

        $I->switchToContentFrame();
    }

    /**
     * @param BackendTester $I
     */
    public function create_one_time_account_copy_to_clipboard(BackendTester $I)
    {
        $I->wantTo('I want to create a temporary frontend account using <copy_to_clipboard> button.');

        $I->click('Generate temporary account');

        $I->click('.btn-copy');

        $I->waitForElement('#username', 5);
    }

    /**
     * @param BackendTester $I
     */
    public function simulate_user_session(BackendTester $I)
    {
        $I->wantTo('I can be logged in as a selected user in the frontend area.');

        $I->click('#simulate-user-1');

        $I->amOnPage('/login');
        $I->canSeeElement('#logout-link');
    }

    /**
     * @param BackendTester $I
     */
    public function create_one_time_account(BackendTester $I)
    {
        $I->wantTo('I want to create a temporary frontend account.');

        $I->click('Generate temporary account');

        $I->amOnUrl(
            $I->grabValueFrom('#url')
        );

        $I->seeInTitle('Catalog');
    }

    /**
     * @param BackendTester $I
     */
    public function terminate_user_session(BackendTester $I)
    {
        $I->wantTo('I can erase all existing sessions associated with selected user.');

        $I->click('#terminate-user-1');

        $I->amOnPage('/login');
        $I->canSeeElement('#login-button');
    }
}
