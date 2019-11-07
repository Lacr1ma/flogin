<?php
declare(strict_types = 1);

namespace LMS\Login\Domain\Validator\Login;

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

use LMS\Login\Domain\Repository\UserRepository;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class PasswordValidator extends \LMS\Login\Domain\Validator\Login\DefaultValidator
{
    /**
     * Valid when user password is correct
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $email
     */
    protected function isValid($email): void
    {
        $this->ensurePasswordIsValid($email);
    }

    /**
     * @param string $password
     */
    private function ensurePasswordIsValid(string $password): void
    {
        $user = $this->findRequestAssociatedUser();

        if ($user && UserRepository::make()->validatePassword($user, $password)) {
            return;
        }

        $this->addError($this->translate('password.not_match'), 1570638576);
    }
}
