<?php
declare(strict_types = 1);

namespace LMS\Login\Domain\Validator;

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
class EmailValidator extends \LMS\Login\Domain\Validator\DefaultValidator
{
    /**
     * Valid only when email does exist in the system
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $email
     */
    protected function isValid($email): void
    {
        $this->ensureEmailExists($email);
    }

    /**
     * We check if passed email does exist in the fe_users table
     * If it's not exist we add an error to the current request
     *
     * @param string $email
     */
    private function ensureEmailExists(string $email): void
    {
        if ($user = UserRepository::make()->retrieveByEmail($email)) {
            return;
        }

        $this->addError($this->translate('email.not_found'), 1570638577);
    }
}
