<?php
/** @noinspection PhpInternalEntityUsedInspection */

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use LMS\Flogin\Support\Redirection\UserRouter;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use LMS\Flogin\Domain\{Model\User, Repository\UserRepository, Validator\DefaultValidator};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserNotLockedValidator extends DefaultValidator
{
    /**
     * Valid when user is real and it's not locked
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $value | username
     * @throws PropagateResponseException
     */
    protected function isValid($value): void
    {
        $this->userFromRequest($value, function (User $user, string $plainPassword) {
            $hash = GeneralUtility::makeInstance(Hash::class);

            if (!$hash->checkPassword($plainPassword, $user->getPassword()) || $user->isNotLocked()) {
                return;
            }

            $this->addError($this->translate('username.locked'), 1574293893);

            $response = UserRouter::redirectToLockedPage();

            throw new PropagateResponseException($response);
        });
    }

    /**
     * Extract user from request and pass though callback back
     */
    private function userFromRequest(string $username, callable $callback): void
    {
        if ($user = UserRepository::make()->retrieveByUsername($username)) {
            $callback($user, $this->getInputPassword());
        }
    }
}
