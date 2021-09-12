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
use TYPO3\CMS\Core\Http\Response;
use LMS\Flogin\Support\TypoScript;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class UserRouter
{
    /**
     * Redirect user to <alreadyAuthenticatedPage>
     */
    public static function redirectToAlreadyAuthenticatedPage(): Response
    {
        $pid = (int)self::redirectSettings()['alreadyAuthenticatedPage'];

        return Redirect::toPage($pid);
    }

    /**
     * Redirects user to <whenTokenExpiredPage>
     */
    public static function redirectToTokenExpiredPage(): Response
    {
        $pid = (int)self::redirectSettings()['error.']['whenTokenExpiredPage'];

        return Redirect::toPage($pid);
    }

    /**
     * Redirects user to <whenTokenNotFoundPage>
     */
    public static function redirectToTokenNotFoundPage(): Response
    {
        $pid = (int)self::redirectSettings()['error.']['whenTokenNotFoundPage'];

        return Redirect::toPage($pid);
    }

    /**
     * Redirect user to <whenLockedPage>
     */
    public static function redirectToLockedPage(): Response
    {
        $pid = (int)self::redirectSettings()['error.']['whenLockedPage'];

        return Redirect::toPage($pid);
    }

    /**
     * Redirect user to <afterUnlockedPage>
     */
    public static function redirectToUnlockedPage(): Response
    {
        $pid = (int)self::redirectSettings()['afterUnlockedPage'];

        return Redirect::toPage($pid);
    }

    /**
     * Retrieve TypoScript settings related to redirect targets
     */
    private static function redirectSettings(): array
    {
        return TypoScript::getSettings()['redirect.'];
    }
}
