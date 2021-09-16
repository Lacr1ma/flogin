<?php
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Domain\Validator\MagicLink;

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

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use LMS\Flogin\Domain\Validator\DefaultValidator;
use TYPO3\CMS\Core\Http\PropagateResponseException;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class NotAuthenticatedValidator extends DefaultValidator
{
    /**
     * Valid when use is not logged in at the current moment
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param \LMS\Flogin\Domain\Model\Request\MagicLinkRequest $value
     * @throws PropagateResponseException
     * @noinspection PhpUnhandledExceptionInspection
     */
    protected function isValid($value): void
    {
        $authenticated = self::context()
            ->getPropertyFromAspect('frontend.user', 'isLoggedIn');

        if (!$authenticated) {
            return;
        }

        $this->addError($this->translate('user.already_logged_in'), 1574293894);

        $response = $this->router()->redirectToAlreadyAuthenticatedPage();

        throw new PropagateResponseException($response);
    }

    /**
     * Retrieve the Context Instance
     *
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     */
    private static function context(): Context
    {
        return GeneralUtility::makeInstance(Context::class);
    }
}
