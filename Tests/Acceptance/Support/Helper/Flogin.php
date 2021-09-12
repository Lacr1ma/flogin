<?php
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Acceptance\Support\Helper;

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

use TYPO3\TestingFramework\Core\Acceptance\Helper\Login;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Flogin extends Login
{
    public function open()
    {
        $webDriver = $this->getWebDriver();

        $newUserSessionId = $this->getUserSessionIdByRole('admin');

        $hasSession = $this->_loadSession();
        if ($hasSession && $newUserSessionId !== '' && $newUserSessionId !== $this->getUserSessionId()) {
            $this->_deleteSession();
            $hasSession = false;
        }

        if (!$hasSession) {
            $webDriver->amOnPage('/typo3/module/web/FloginLogin');
            $this->_createSession($newUserSessionId);
        }

        $webDriver->amOnPage('/typo3/module/web/FloginLogin');
        $webDriver->switchToIFrame();
    }
}
