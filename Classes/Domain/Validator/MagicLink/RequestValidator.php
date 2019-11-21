<?php
declare(strict_types = 1);

namespace LMS\Login\Domain\Validator\MagicLink;

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

use LMS\Login\{Domain\Repository\LinkRepository, Support\Redirection\UserRouter};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class RequestValidator extends \LMS\Login\Domain\Validator\DefaultValidator
{
    /**
     * Valid when magic link does exist in the database and it's not expired yet
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param \LMS\Login\Domain\Model\Request\MagicLinkRequest $loginRequest
     */
    protected function isValid($loginRequest): void
    {
        $magicLink = LinkRepository::make()->find($loginRequest->getToken());

        if ($magicLink === null) {
            UserRouter::redirectToTokenNotFoundPage();
        }

        if ($magicLink->isExpired()) {
            UserRouter::redirectToTokenExpiredPage();
        }

        $magicLink->delete();
    }
}
