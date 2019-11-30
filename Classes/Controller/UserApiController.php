<?php
declare(strict_types = 1);

namespace LMS\Login\Controller;

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

use LMS\Login\Support\Controller\Backend\{CreatesOneTimeAccount, SimulatesFrontendLogin};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserApiController extends Base\ApiController
{
    use SimulatesFrontendLogin, CreatesOneTimeAccount;

    /**
     * {@inheritdoc}
     */
    protected function getRootName(): string
    {
        return 'user';
    }

    /**
     * Give the logged in user information
     */
    public function currentAction(): void
    {
        $this->showAction(self::currentUid());
    }

    /**
     * Give the logged in user information
     */
    public function authenticatedAction(): void
    {
        $this->view->assign('value', ['authenticated' => self::isLoggedIn()]);
    }

    /**
     * Attempt to login the FE user by it's name
     *
     * @param string $username
     */
    public function simulateLoginAction(string $username): void
    {
        $this->simulateLoginFor($username);
    }

    /**
     * Attempt to logout the FE user by it's uid
     *
     * @param int $user
     */
    public function terminateFrontendSessionAction(int $user): void
    {
        $this->terminateSessionFor($user);
    }

    /**
     * Create one time user and log in
     *
     * @param string $hash
     */
    public function createOneTimeAccountAction(string $hash): void
    {
        if ($user = $this->createTemporaryFrontendAccount($hash)) {
            $this->authorizeTemporaryUser($user, $hash);
        }
    }
}
