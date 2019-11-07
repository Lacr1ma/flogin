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

use LMS\Login\Support\TypoScript;
use LMS\Login\Domain\{Model\User, Repository\UserRepository};


/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class DefaultValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    /**
     * Attempt to retrieve the <username> that has been sent thought the current HTTP Request
     *
     * @return string
     */
    protected function getInputUserName(): string
    {
        return $GLOBALS['TYPO3_REQUEST']->getParsedBody()['tx_login_login']['username'] ?: '';
    }

    /**
     * Attempt to retrieve the <password> that has been sent thought the current HTTP Request
     *
     * @return string
     */
    protected function getInputPassword(): string
    {
        return $GLOBALS['TYPO3_REQUEST']->getParsedBody()['tx_login_login']['password'] ?: '';
    }

    /**
     * Helper for getting proper translations inside parent relations
     *
     * @param string $key
     * @param array  $arguments
     *
     * @return string
     */
    protected function translate(string $key, array $arguments = []): string
    {
        $file = $this->getTranslationFile();

        return $this->translateErrorMessage("{$file}:{$key}", '', $arguments) ?: '';
    }

    /**
     * Retrieve the translation file path for validation
     * By default it's <LLL:EXT:login/Resources/Private/Language/validation.xlf>
     *
     * @return string
     */
    private function getTranslationFile(): string
    {
        return (string)TypoScript::getSettings()['validation.']['translationFilePrefix'];
    }

    /**
     * @return \LMS\Login\Domain\Model\User|null
     */
    protected function findRequestAssociatedUser(): ?User
    {
        return UserRepository::make()->retrieveByUsername($this->getInputUserName());
    }
}
