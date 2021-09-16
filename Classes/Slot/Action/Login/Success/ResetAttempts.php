<?php
/** @noinspection PhpUnusedParameterInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Slot\Action\Login\Success;

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

use LMS\Flogin\Event\LoginSuccessEvent;
use LMS\Flogin\Event\UserUnlockedEvent;
use LMS\Flogin\Support\ThrottlesLogins;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ResetAttempts
{
    protected ThrottlesLogins $throttler;

    public function injectThrottler(ThrottlesLogins $throttler): void
    {
        $this->throttler = $throttler;
    }

    /**
     * User has been unlocked, clear all previous fails
     */
    public function unlocked(UserUnlockedEvent $event): void
    {
        $this->throttler->clearAttempts();
    }

    /**
     * Successful login attempt detected, clear all previous fails
     */
    public function loggedIn(LoginSuccessEvent $event): void
    {
        $this->throttler->clearAttempts();
    }
}
