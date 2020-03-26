<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support\Redirection;

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

use LMS\Facade\Extbase\Redirect;
use LMS\Flogin\Support\TypoScript;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class UserRouter
{
    /**
     * Redirect user to <afterLoginPage>
     */
    public static function redirectToAfterLoginPage(): void
    {
        $pid = (int)self::redirectSettings()['afterLoginPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <alreadyAuthenticatedPage>
     */
    public static function redirectToAlreadyAuthenticatedPage(): void
    {
        $pid = (int)self::redirectSettings()['alreadyAuthenticatedPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <afterLogoutPage>
     */
    public static function redirectToAfterLogoutPage(): void
    {
        $pid = (int)self::redirectSettings()['afterLogoutPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <afterForgotPasswordNotificationSentPage>
     */
    public static function redirectToAfterForgotPasswordNotificationSentPage(): void
    {
        $pid = (int)self::redirectSettings()['afterForgotPasswordNotificationSentPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <afterResetPasswordFormSubmittedPage>
     */
    public static function redirectToAfterResetPasswordFormSubmittedPage(): void
    {
        $pid = (int)self::redirectSettings()['afterResetPasswordFormSubmittedPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <afterMagicLinkNotificationSentPage>
     */
    public static function redirectToAfterMagicLinkNotificationSentPage(): void
    {
        $pid = (int)self::redirectSettings()['afterMagicLinkNotificationSentPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirects user to <whenTokenExpiredPage>
     */
    public static function redirectToTokenExpiredPage(): void
    {
        $pid = (int)self::redirectSettings()['error.']['whenTokenExpiredPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirects user to <whenTokenNotFoundPage>
     */
    public static function redirectToTokenNotFoundPage(): void
    {
        $pid = (int)self::redirectSettings()['error.']['whenTokenNotFoundPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <whenLockedPage>
     */
    public static function redirectToLockedPage(): void
    {
        $pid = (int)self::redirectSettings()['error.']['whenLockedPage'];

        Redirect::toPage($pid);
    }

    /**
     * Redirect user to <afterUnlockedPage>
     */
    public static function redirectToUnlockedPage(): void
    {
        $pid = (int)self::redirectSettings()['afterUnlockedPage'];

        Redirect::toPage($pid);
    }

    /**
     * Retrieve TypoScript settings related to redirect area
     *
     * @return array
     */
    private static function redirectSettings(): array
    {
        return TypoScript::getSettings()['redirect.'];
    }
}
