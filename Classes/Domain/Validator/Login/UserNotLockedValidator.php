<?php
declare(strict_types = 1);

namespace LMS\Flogin\Domain\Validator\Login;

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

use LMS\Flogin\Hash\Hash;
use LMS\Flogin\Support\Redirection\UserRouter;
use LMS\Flogin\Domain\{Model\User, Repository\UserRepository};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserNotLockedValidator extends \LMS\Flogin\Domain\Validator\DefaultValidator
{
    /**
     * Valid when user is real and it's not locked
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $username
     */
    protected function isValid($username): void
    {
        $this->userFromRequest($username, function (User $user, string $plainPassword) {
            if (!Hash::checkPassword($plainPassword, $user->getPassword()) || $user->isNotLocked()) {
                return;
            }

            $this->addError($this->translate('username.locked'), 1574293893);

            UserRouter::redirectToLockedPage();
        });
    }

    /**
     * Extract user from request and pass though callback back
     *
     * @param string $username
     * @param callable $callback
     */
    private function userFromRequest(string $username, callable $callback): void
    {
        if ($user = UserRepository::make()->retrieveByUsername($username)) {
            $callback($user, $this->getInputPassword());
        }
    }
}
