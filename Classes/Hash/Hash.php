<?php
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Hash;

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

use TYPO3\CMS\Core\Crypto\{PasswordHashing\PasswordHashFactory, PasswordHashing\PasswordHashInterface};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Hash
{
    private PasswordHashFactory $passwordFactory;

    public function __construct(PasswordHashFactory $factory)
    {
        $this->passwordFactory = $factory;
    }

    /**
     * Generates the hash for the passed plain password
     */
    public function encryptPassword(string $plain): string
    {
        return $this->getHashFactory()->getHashedPassword($plain);
    }

    /**
     * Check if the passed <plain password> matches the <encrypted password>
     */
    public function checkPassword(string $plain, string $encrypted): bool
    {
        return $this->getHashFactory()->checkPassword($plain, $encrypted);
    }

    /**
     * Determine configured default hash method and return an instance relate to FE scope
     */
    private function getHashFactory(): PasswordHashInterface
    {
        return $this->passwordFactory->getDefaultHashInstance('FE');
    }
}
