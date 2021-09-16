<?php
declare(strict_types = 1);

namespace LMS\Flogin\Domain\Validator\Login;

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

use LMS\Flogin\{Domain\Validator\DefaultValidator,
    Event\LockoutEvent,
    Event\LoginAttemptFailedEvent,
    Support\ThrottlesLogins};
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class AttemptLimitNotReachedValidator extends DefaultValidator
{
    /**
     * Valid if request IP is not locked
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string $value
     */
    protected function isValid($value): void
    {
        if ($this->throttler()->hasTooManyAttempts()) {
            $this->addLockoutError();
            return;
        }

        $this->dispatcher()->dispatch(
            new LoginAttemptFailedEvent($this->getInputUserName())
        );
    }

    /**
     * Fire the lockout event when brute force attack detected
     */
    protected function addLockoutError(): void
    {
        // We fire lock out event only when we have a real user
        if ($user = $this->findRequestAssociatedUser()) {
            $this->dispatcher()->dispatch(
                new LockoutEvent($user)
            );
        }

        $waitingTime = $this->calculateWaitingTimeInMinutes();

        $this->addError($this->translate('login.limit_reached', [$waitingTime]), 1572479106);
    }

    /**
     * Builds the number of minutes of lock
     */
    protected function calculateWaitingTimeInMinutes(): float
    {
        $seconds = $this->throttler()->limiter()->availableIn(
            $this->throttler()->throttleKey()
        );

        return ceil(ceil($seconds / 60) / 60);
    }

    private function throttler(): ThrottlesLogins
    {
        return GeneralUtility::makeInstance(ThrottlesLogins::class);
    }
}
