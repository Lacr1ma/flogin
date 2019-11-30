<?php
declare(strict_types = 1);

namespace LMS\Login\Support\Controller\Backend;

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

use LMS\Login\{Manager\SessionManager, Guard\SessionGuard};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait SimulatesFrontendLogin
{
    /**
     * Signs up the requested user and connects the session to the currently logged in BE User.
     *
     * @param string $username
     */
    public function simulateLoginFor(string $username): void
    {
        $_POST['be_user'] = $GLOBALS['BE_USER']->user;

        SessionGuard::make()->startCoreLogin($username, $_POST['be_user']['ses_id'], false);
    }

    /**
     * Finish all active sessions associated to passed user
     *
     * @param int $user
     */
    public function terminateSessionFor(int $user): void
    {
        SessionManager::terminateFrontendSession($user);
    }
}
