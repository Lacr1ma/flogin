<?php
declare(strict_types = 1);

namespace LMS\Flogin\Middleware\Api;

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

use LMS\Facade\Extbase\Registry;
use LMS\Flogin\Support\TypoScript;
use TYPO3\CMS\Core\Utility\HttpUtility;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class VerifyAccountCreationHash extends \LMS\Routes\Middleware\Api\AbstractRouteMiddleware
{
    /**
     * Ensure valid hash is passed
     *
     * {@inheritDoc}
     */
    public function process(): void
    {
        $hash = $this->getRequest()->getQueryParams()['hash'];

        if (Registry::contains('tx_flogin_hash', $hash)) {
            return;
        }

        $this->redirectToHashErrorPage();
    }

    /**
     *
     */
    private function redirectToHashErrorPage(): void
    {
        HttpUtility::redirect(
            $this->invalidHashUrl()
        );
    }

    /**
     * @return string
     */
    private function invalidHashUrl(): string
    {
        return "/index.php?id={$this->hashErrorPage()}";
    }

    /**
     * @return int
     */
    private function hashErrorPage(): int
    {
        return (int)TypoScript::getSettings()['redirect.']['error.']['whenOneTimeAccountHashNotFoundPage'];
    }
}
