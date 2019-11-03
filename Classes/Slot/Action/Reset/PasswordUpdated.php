<?php
declare(strict_types = 1);

namespace LMS\Login\Slot\Action\Reset;

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
use TYPO3\CMS\Core\Session\SessionManager;
use LMS\Login\Support\Redirection\UserRouter;
use LMS\Login\Domain\Model\Request\ResetPasswordRequest;
use LMS\Login\Slot\Notification\PasswordChangedNotification;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class PasswordUpdated
{
    /**
     * @param \LMS\Login\Domain\Model\Request\ResetPasswordRequest $request
     */
    public function execute(ResetPasswordRequest $request): void
    {
        $this->invalidateUserSessions($request->getUser()->getUid());

        PasswordChangedNotification::make()->send($request->getUser());

        UserRouter::redirectToAfterResetFormSubmittedPage();
    }

    /**
     * @param int $user
     */
    protected function invalidateUserSessions(int $user): void
    {
        $session = ObjectManageable::createObject(SessionManager::class);
        $session->invalidateAllSessionsByUserId($session->getSessionBackend('FE'), $user);
    }
}
