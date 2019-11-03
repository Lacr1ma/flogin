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

use LMS\Login\Tests\Acceptance\Support\AcceptanceTester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class SchedulerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function clear_expired_reset_password_links(AcceptanceTester $I)
    {
        $I->wantTo('I can run a scheduler task: <Clear all expired reset password links>.');

        $I->runShellCommand('bin/typo3 scheduler:run --task=1 -f');

        $I->seeResultCodeIs(0);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function clear_expired_magic_links(AcceptanceTester $I)
    {
        $I->wantTo('I can run a scheduler task: <Clear all expired magic links>.');

        $I->runShellCommand('bin/typo3 scheduler:run --task=2 -f');

        $I->seeResultCodeIs(0);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function unlock_users(AcceptanceTester $I)
    {
        $I->wantTo('I can run a scheduler task: <Unlock users>.');

        $I->runShellCommand('bin/typo3 scheduler:run --task=3 -f');

        $I->seeResultCodeIs(0);
    }
}
