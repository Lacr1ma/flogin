<?php
declare(strict_types = 1);

namespace LMS\Flogin\Event;

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

use LMS\Flogin\Domain\Model\User;
use LMS\Facade\Extbase\PsrDispatcher;
use LMS\Flogin\Domain\Model\Request\{MagicLinkRequest, ResetPasswordRequest};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait SessionEvent
{
    public function fireLoginAttemptEvent(User $user, string $plainPassword, bool $remember = false): void
    {
        $args = [$user, $plainPassword, $remember];

        PsrDispatcher::emit(new LoginAttemptEvent(...$args));
    }

    public function fireLoginAttemptFailedEvent(string $username): void
    {
        PsrDispatcher::emit(new LoginAttemptFailedEvent($username));
    }

    public function fireLoginFailedInCoreEvent(User $user): void
    {
        PsrDispatcher::emit(new LoginAttemptFailedInCoreEvent($user));
    }

    public function fireLoginSucceededEvent(User $user, bool $remember): void
    {
        PsrDispatcher::emit(new LoginSuccessEvent($user, $remember));
    }

    public function fireLogoutSucceededEvent(User $user): void
    {
        PsrDispatcher::emit(new LogoutSuccessEvent($user));
    }

    public function fireLoginLockoutEvent(User $user): void
    {
        PsrDispatcher::emit(new LockoutEvent($user));
    }

    public function firePasswordResetEvent(ResetPasswordRequest $request): void
    {
        PsrDispatcher::emit(new PasswordHasBeenResetEvent($request));
    }

    public function fireLoginUnlockedEvent(User $user): void
    {
        PsrDispatcher::emit(new UserUnlockedEvent($user));
    }

    public function fireSendResetLinkRequestEvent(ResetPasswordRequest $request): void
    {
        PsrDispatcher::emit(new SendResetLinkRequestEvent($request));
    }

    public function fireSendMagicLinkEvent(MagicLinkRequest $request): void
    {
        PsrDispatcher::emit(new SendMagicLinkRequestEvent($request));
    }

    public function fireMagicLinkAppliedEvent(string $token): void
    {
        PsrDispatcher::emit(new MagicLinkAppliedEvent($token));
    }
}
