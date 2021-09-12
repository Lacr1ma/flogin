<?php
/** @noinspection PhpInternalEntityUsedInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Domain\Validator\ResetPassword;

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

use TYPO3\CMS\Core\Http\PropagateResponseException;
use LMS\Flogin\Domain\Model\Request\ResetPasswordRequest;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class AttemptValidator extends RequestValidator
{
    /**
     * Valid when reset password request contains proper password, and it's confirmation
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param ResetPasswordRequest $value
     * @throws PropagateResponseException
     */
    protected function isValid($value): void
    {
        parent::isValid($value);

        if ($value->isConfirmationMatching()) {
            return;
        }

        $this->addError($this->translate('password_confirmation.not_match'), 1570638578);
    }
}
