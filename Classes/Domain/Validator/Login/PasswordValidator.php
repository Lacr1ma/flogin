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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use LMS\Flogin\Domain\Validator\DefaultValidator;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class PasswordValidator extends DefaultValidator
{
    /**
     * Valid when user password is correct
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $value | email
     */
    protected function isValid($value): void
    {
        $this->ensurePasswordIsValid($value);
    }

    private function ensurePasswordIsValid(string $password): void
    {
        $user = $this->findRequestAssociatedUser();

        $hash = GeneralUtility::makeInstance(Hash::class);

        if ($user && $hash->checkPassword($password, $user->getPassword())) {
            return;
        }

        $this->addError($this->translate('password.not_match'), 1570638576);
    }
}
