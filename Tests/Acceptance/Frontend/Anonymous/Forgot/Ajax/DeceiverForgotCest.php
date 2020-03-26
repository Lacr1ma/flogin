<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Acceptance\Frontend\Anonymous\Forgot\Ajax;

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
class DeceiverForgotCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function email_required(AcceptanceTester $I)
    {
        $I->wantTo('I see the error messages when I am requesting the forget password to the unknown email address.');

        $I->amRequestingForgotLinkAjax('unknown@example.com');

        $I->waitForElement('.forgot-email-is-invalid');
        $I->see('This email address is not connected to any user in our system.', '.forgot-email-is-invalid');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function notification_can_be_sent(AcceptanceTester $I)
    {
        $I->wantTo('I am requesting the forget password notification and I get it.');

        $I->amRequestingForgotLinkAjax('locked@example.com');

        $I->waitForElement('#notification-sent');
    }
}
