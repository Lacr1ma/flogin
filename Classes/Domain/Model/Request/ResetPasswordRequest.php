<?php
declare(strict_types = 1);

namespace LMS\Login\Domain\Model\Request;

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

use LMS\Login\Domain\Model\Resets;
use LMS\Login\Support\Domain\Property\PasswordConfirmation;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ResetPasswordRequest extends \LMS\Login\Domain\Model\Request\AbstractRequest
{
    use PasswordConfirmation;

    /**
     * {@inheritDoc}
     */
    public function getUrl(): string
    {
        $args = ['request' => $this];

        return $this->buildUrl('showResetForm', 'ResetPassword', $args);
    }

    /**
     * {@inheritDoc}
     */
    public function notify(): void
    {
        $this->fireSendResetLinkRequestEvent($this);
    }

    /**
     * {@inheritDoc}
     */
    public function getExpires(): int
    {
        return Resets::getLifetimeInMinutes();
    }
}
