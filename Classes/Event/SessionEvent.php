<?php
declare(strict_types = 1);

namespace LMS\Login\Event;

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

use LMS\Login\Domain\Model\User;
use LMS\Facade\Extbase\Dispatcher;
use LMS\Login\Domain\Model\Request\{MagicLinkRequest, ResetPasswordRequest};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait SessionEvent
{
    /**
     * @param \LMS\Login\Domain\Model\User $user
     * @param string                       $plainPassword
     * @param bool                         $remember
     */
    public function fireLoginAttemptEvent(User $user, string $plainPassword, bool $remember): void
    {
        $args = [$user, $plainPassword, $remember];

        Dispatcher::emit(SessionEvent::class, 'loginAttempt', $args);
    }

    /**
     * @param string $username
     */
    public function fireLoginAttemptFailedEvent(string $username): void
    {
        Dispatcher::emit(SessionEvent::class, 'loginAttemptFailed', [$username]);
    }

    /**
     * @param \LMS\Login\Domain\Model\User $user
     */
    public function fireLoginFailedInCoreEvent(User $user): void
    {
        Dispatcher::emit(SessionEvent::class, 'loginAttemptFailedInCore', [$user]);
    }

    /**
     * @param \LMS\Login\Domain\Model\User $user
     * @param bool                         $remember
     */
    public function fireLoginSucceededEvent(User $user, bool $remember): void
    {
        Dispatcher::emit(SessionEvent::class, 'loginSuccess', [$user, $remember]);
    }

    /**
     * @param \LMS\Login\Domain\Model\User $user
     */
    public function fireLogoutSucceededEvent(User $user): void
    {
        Dispatcher::emit(SessionEvent::class, 'logoutSuccess', [$user]);
    }

    /**
     * @param \LMS\Login\Domain\Model\User $user
     */
    public function fireLoginLockoutEvent(User $user): void
    {
        Dispatcher::emit(SessionEvent::class, 'lockout', [$user]);
    }

    /**
     * @param \LMS\Login\Domain\Model\Request\ResetPasswordRequest $request
     */
    public function firePasswordResetEvent(ResetPasswordRequest $request): void
    {
        Dispatcher::emit(SessionEvent::class, 'passwordHasBeenReset', [$request]);
    }

    /**
     * @param \LMS\Login\Domain\Model\User $user $user
     */
    public function fireLoginUnlockedEvent(User $user): void
    {
        Dispatcher::emit(SessionEvent::class, 'userUnlocked', [$user]);
    }

    /**
     * @param \LMS\Login\Domain\Model\Request\ResetPasswordRequest $request
     */
    public function fireSendResetLinkRequestEvent(ResetPasswordRequest $request): void
    {
        Dispatcher::emit(SessionEvent::class, 'sendResetLinkRequest', [$request]);
    }

    /**
     * @param \LMS\Login\Domain\Model\Request\MagicLinkRequest $request
     */
    public function fireSendMagicLinkEvent(MagicLinkRequest $request): void
    {
        Dispatcher::emit(SessionEvent::class, 'sendMagicLinkRequest', [$request]);
    }

    /**
     * @param string $token
     */
    public function fireMagicLinkAppliedEvent(string $token): void
    {
        Dispatcher::emit(SessionEvent::class, 'magicLinkApplied', [$token]);
    }
}
