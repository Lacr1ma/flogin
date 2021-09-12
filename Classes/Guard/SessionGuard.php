<?php
declare(strict_types = 1);

namespace LMS\Flogin\Guard;

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

use LMS\Flogin\{Domain\Model\User, Domain\Repository\UserRepository, Event\SessionEvent};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class SessionGuard
{
    use SessionEvent;

    protected UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    /**
     * Log a user into the application.
     */
    public function login(User $user, string $plainPassword, bool $remember = false): void
    {
        $this->startCoreLogin($user->getUsername(), $plainPassword, $remember);

        if (!$GLOBALS['TSFE']->fe_user->loginSessionStarted) {
            $this->fireLoginFailedInCoreEvent($user);
            return;
        }

        $this->fireLoginSucceededEvent($user, $remember);
    }

    /**
     * Logout current user from the application.
     */
    public function logoff(): void
    {
        $user = $this->userRepository->current();

        $GLOBALS['TSFE']->fe_user->logoff();

        $user && $this->fireLogoutSucceededEvent($user);
    }

    /**
     * Initialize credentials and proxy the request to the TYPO3 Core
     */
    public function startCoreLogin(string $username, string $password, bool $remember = false): void
    {
        $_POST['user'] = $username;
        $_POST['pass'] = $password;
        $_POST['logintype'] = 'login';
        $_POST['permalogin'] = (int)$remember;

        $GLOBALS['TSFE']->fe_user->checkPid = false;
        $GLOBALS['TSFE']->fe_user->start();
    }
}
