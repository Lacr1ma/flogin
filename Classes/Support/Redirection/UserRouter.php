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

use LMS\Flogin\Support\Redirect;
use LMS\Flogin\Support\TypoScript;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class UserRouter
{
    protected Redirect $redirect;

    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Redirect user to <alreadyAuthenticatedPage>
     */
    public function redirectToAlreadyAuthenticatedPage(): ResponseInterface
    {
        $pid = (int)self::redirectSettings()['alreadyAuthenticatedPage'];

        return $this->redirect->toPage($pid);
    }

    /**
     * Redirects user to <whenTokenExpiredPage>
     */
    public function redirectToTokenExpiredPage(): ResponseInterface
    {
        $pid = (int)self::redirectSettings()['error.']['whenTokenExpiredPage'];

        return $this->redirect->toPage($pid);
    }

    /**
     * Redirects user to <whenTokenNotFoundPage>
     */
    public function redirectToTokenNotFoundPage(): ResponseInterface
    {
        $pid = (int)self::redirectSettings()['error.']['whenTokenNotFoundPage'];

        return $this->redirect->toPage($pid);
    }

    /**
     * Redirect user to <whenLockedPage>
     */
    public function redirectToLockedPage(): ResponseInterface
    {
        $pid = (int)self::redirectSettings()['error.']['whenLockedPage'];

        return $this->redirect->toPage($pid);
    }

    /**
     * Redirect user to <afterUnlockedPage>
     */
    public function redirectToUnlockedPage(): ResponseInterface
    {
        $pid = (int)self::redirectSettings()['afterUnlockedPage'];

        return $this->redirect->toPage($pid);
    }

    /**
     * Retrieve TypoScript settings related to redirect targets
     */
    private function redirectSettings(): array
    {
        return TypoScript::getSettings()['redirect.'];
    }
}
