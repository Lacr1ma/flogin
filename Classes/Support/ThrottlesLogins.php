<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ThrottlesLogins
{
    private int $maxAttempts;
    private int $decayMinutes;
    private RateLimiter $limiter;

    public function __construct()
    {
        $this->maxAttempts = (int)$this->settings()['maxAttempts'];
        $this->decayMinutes = (int)$this->settings()['decayMinutes'];

        $this->limiter = GeneralUtility::makeInstance(RateLimiter::class);
    }

    public function limiter(): RateLimiter
    {
        return $this->limiter;
    }

    /**
     * Determine if the session has too many attempts
     */
    public function hasTooManyAttempts(): bool
    {
        return $this->limiter->tooManyAttempts(
            $this->throttleKey(), $this->maxAttempts
        );
    }

    /**
     * Increment the attempts count for the session.
     */
    public function incrementAttempts(): void
    {
        $this->limiter->hit(
            $this->throttleKey(), $this->decayMinutes * 60
        );
    }

    /**
     * Clear registered attempts associated with REQUEST IP
     */
    public function clearAttempts(): void
    {
        $this->limiter->clear($this->throttleKey());
    }

    /**
     * Use request ip address as a throttle key
     */
    public function throttleKey(): string
    {
        return md5(Request::createFromGlobals()->getClientIp() ?? '');
    }

    /**
     * Retrieve TypoScript settings related to throttling area
     */
    private function settings(): array
    {
        return TypoScript::getSettings()['throttling.'];
    }
}
