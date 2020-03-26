<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Acceptance\Frontend\Anonymous\Reset;

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

use Codeception\Util\HttpCode;
use LMS\Flogin\Tests\Acceptance\Support\AcceptanceTester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class DeceiverResetCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function redirect_token_not_found(AcceptanceTester $I)
    {
        $I->wantTo('I wanna be redirect to a <tokenDoesNotExist> page when token already deleted.');

        $I->amRequestingPasswordResetNotification('dummy@example.com');

        $resetPasswordUrl = $I->extractLinkFromLastMail();

        $I->amOnUrl($resetPasswordUrl);
        $password = $confirmation = 'password';

        $I->fillField('tx_flogin_flogin[request][password]', $password);
        $I->fillField('tx_flogin_flogin[request][passwordConfirmation]', $confirmation);
        $I->click('#change-password-link');

        $I->amOnUrl($resetPasswordUrl);

        $I->seeInTitle('Token does not exist');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function reset_password_should_match(AcceptanceTester $I)
    {
        $I->wantTo('I wanna see an error, when my confirmation password invalid.');

        $email = 'dummy@example.com';
        $password = 'password';

        $I->amChangingPassword($email, $password, 'bla');

        $I->seeElement('.alert-danger');
    }
}
