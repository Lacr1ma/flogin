<?php
declare(strict_types = 1);

namespace LMS\Login\Controller\Api;

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

use LMS\Facade\Extbase\Validation;
use LMS\Login\Support\Controller\Login\AuthenticatesUsers;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class LoginApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     */
    public function showLoginFormAction(): void
    {
    }

    /**
     * @param string $username
     * @param string $password
     * @param bool   $remember
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Login\Domain\Validator\Login\UsernameValidator", param="username")
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Login\Domain\Validator\Login\PasswordValidator", param="password")
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Login\Domain\Validator\Login\UserNotLockedValidator", param="username")
     */
    public function authAction(string $username, string $password, bool $remember): void
    {
        $this->login([$username, $password], $remember);
    }

    /**
     * Log the user out of the application.
     */
    public function logoutAction(): void
    {
        $this->logoff();
    }

    /**
     * Build proper error messages for outside use
     *
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function errorAction(): void
    {
        $errors = Validation::parseErorrs(
            $this->getControllerContext()->getArguments()
        );

        $this->view->assign('errors', $errors);
    }
}
