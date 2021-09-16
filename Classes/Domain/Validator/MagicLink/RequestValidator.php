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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use LMS\Flogin\{Domain\Repository\LinkRepository, Domain\Validator\DefaultValidator};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class RequestValidator extends DefaultValidator
{
    /**
     * Valid when magic link does exist in the database, and it's not expired yet
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param \LMS\Flogin\Domain\Model\Request\MagicLinkRequest $value
     * @throws PropagateResponseException
     */
    protected function isValid($value): void
    {
        $linkRepository = GeneralUtility::makeInstance(LinkRepository::class);

        $magicLink = $linkRepository->find($value->getToken());

        if ($magicLink === null) {
            throw new PropagateResponseException(
                $this->router()->redirectToTokenNotFoundPage()
            );
        }

        if ($magicLink->isExpired()) {
            throw new PropagateResponseException(
                $this->router()->redirectToTokenExpiredPage()
            );
        }

        $magicLink->delete();
    }
}
