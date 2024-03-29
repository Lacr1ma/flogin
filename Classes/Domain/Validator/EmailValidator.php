<?php
declare(strict_types = 1);

namespace LMS\Flogin\Domain\Validator;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use LMS\Flogin\Domain\Repository\UserRepository;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class EmailValidator extends DefaultValidator
{
    /**
     * Valid only when email does exist in the system
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $value
     */
    protected function isValid($value): void
    {
        $this->ensureEmailExists($value);
    }

    /**
     * We check if passed email does exist in the fe_users table
     * If it's not exist we add an error to the current request
     */
    private function ensureEmailExists(string $email): void
    {
        $userRepository = GeneralUtility::makeInstance(UserRepository::class);

        if ($userRepository->retrieveByEmail($email)) {
            return;
        }

        $this->addError($this->translate('email.not_found'), 1570638577);
    }
}
