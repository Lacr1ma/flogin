<?php
declare(strict_types = 1);

namespace LMS\Login\Hash;

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

use LMS3\Support\ObjectManageable;
use TYPO3\CMS\Core\Crypto\{Random, PasswordHashing\PasswordHashFactory, PasswordHashing\PasswordHashInterface};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Hash
{
    /**
     * Generates cryptographic secure pseudo-random bytes
     *
     * @param int $length
     *
     * @return string
     */
    public static function randomString(int $length = 64): string
    {
        return md5(
            self::getRandom()->generateRandomBytes($length)
        );
    }

    /**
     * Generates the hash for the passed plain password
     *
     * @param string $plain
     *
     * @return string
     */
    public static function encryptPassword(string $plain): string
    {
        return self::getHashFactory()->getHashedPassword($plain);
    }

    /**
     * Determine configured default hash method and return an instance relate to FE scope
     *
     * @return \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface
     */
    public static function getHashFactory(): PasswordHashInterface
    {
        return ObjectManageable::createObject(PasswordHashFactory::class)->getDefaultHashInstance('FE');
    }

    /**
     * Returns TYPO3 Core pseudo-random generator
     *
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     * @noinspection   PhpIncompatibleReturnTypeInspection
     *
     * @return \TYPO3\CMS\Core\Crypto\Random
     */
    private static function getRandom(): Random
    {
        return ObjectManageable::createObject(Random::class);
    }
}
