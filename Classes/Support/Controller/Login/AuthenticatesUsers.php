<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support\Controller\Login;

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

use LMS\Flogin\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use LMS\Flogin\{Event\LoginAttemptEvent, Guard\SessionGuard};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait AuthenticatesUsers
{
    protected SessionGuard $guard;
    protected EventDispatcher $dispatcher;
    protected UserRepository $userRepository;

    public function injectUsersRepository(UserRepository $repository, EventDispatcher $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
        $this->userRepository = $repository;
    }

    public function injectSessionGuard(SessionGuard $guard): void
    {
        $this->guard = $guard;
    }

    /**
     * Attempt to find the user by credentials and notify listeners
     */
    public function login(array $credentials, bool $remember = false): void
    {
        [$username, $plainPassword] = $credentials;

        if ($user = $this->userRepository->retrieveByUsername($username)) {
            $this->dispatcher->dispatch(
                new LoginAttemptEvent($user, $plainPassword, $remember)
            );
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logoff(): void
    {
        $this->guard->logoff();
    }
}
