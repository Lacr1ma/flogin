<?php
/** @noinspection PhpUnused */

declare(strict_types = 1);

namespace LMS\Flogin\Domain\Model;

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
use LMS\Flogin\Support\Domain\Property\Email;
use LMS\Flogin\Support\Domain\Property\Endtime;
use LMS\Flogin\Support\Domain\Property\IsOnline;
use LMS\Flogin\Support\Domain\Property\Password;
use LMS\Flogin\Support\Domain\Property\Username;
use LMS\Flogin\Support\Domain\Action\User\{UrlManagement, Lockable};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class User extends AbstractModel
{
    use Endtime, IsOnline, Email, Password, Username, Lockable, UrlManagement;

    /**
     * Create new Reset Password Request and process it
     */
    public function sendPasswordResetNotification(): void
    {
        $request = GeneralUtility::makeInstance(Request\ResetPasswordRequest::class, $this);

        $request->notify();
    }

    /**
     * Create new Magic Link Request and process it
     */
    public function sendMagicLinkNotification(): void
    {
        $request = GeneralUtility::makeInstance(Request\MagicLinkRequest::class, $this);

        $request->notify();
    }

    public function getUnlockActionUrl(): string
    {
        $args = ['email' => $this->getEmail()];

        return $this->buildUrl('unlock', 'Locker', $args);
    }

    public function getForgotPasswordFormUrl(): string
    {
        $args = ['predefinedEmail' => $this->getEmail()];

        return $this->buildUrl('showForgotForm', 'ForgotPassword', $args);
    }
}
