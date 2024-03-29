<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support\Controller\Backend;

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

use LMS\Flogin\{Manager\SessionManager, Guard\SessionGuard};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait SimulatesFrontendLogin
{
    protected SessionGuard $guard;
    private SessionManager $session;

    public function injectSessionGuard(SessionGuard $guard): void
    {
        $this->guard = $guard;
    }

    public function injectSessionManager(SessionManager $manager): void
    {
        $this->session = $manager;
    }

    /**
     * Signs up the requested user and connects the session to the currently logged in BE User.
     */
    public function simulateLoginFor(string $username): void
    {
        $this->guard->startCoreLogin($username, 'password');
    }

    /**
     * Finish all active sessions associated to passed user
     */
    public function terminateSessionFor(int $user): void
    {
        $this->session->terminateFrontendSession($user);
    }
}
