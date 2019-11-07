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

use LMS\Login\Support\Controller\Backend\SimulatesFrontendLogin;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserApiController extends Base\ApiController
{
    use SimulatesFrontendLogin;

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
        $this->checkAccess();

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
     * @param string $username
     */
    public function simulateLoginAction(string $username): void
    {
        $this->view->assign('value', [$this->simulateLoginFor($username)]);
    }

    /**
     * @param int $user
     */
    public function terminateFrontendSessionAction(int $user): void
    {
        $this->view->assign('value', [$this->terminateSessionFor($user)]);
    }
}
