<?php
declare(strict_types = 1);

namespace LMS\Login\Support\Controller\Login;

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
use LMS\Login\{Event\SessionEvent, Guard\SessionGuard};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait AuthenticatesUsers
{
    use SessionEvent;

    /**
     * @param array $credentials
     * @param bool  $remember
     */
    public function login(array $credentials, bool $remember): void
    {
        [$username, $plainPassword] = $credentials;

        $user = UserRepository::make()->retrieveByUsername($username);

        $this->fireLoginAttemptEvent($user, $plainPassword, $remember);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(): void
    {
        SessionGuard::make()->logout();
    }
}
