<?php
declare(strict_types = 1);

namespace LMS\Login\Domain\Model;

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

use LMS3\Support\Model\StorageActions;
use LMS\Login\Support\Domain\Property\{Endtime, IsOnline};
use LMS\Login\Support\Domain\Action\User\{UrlManagement, Lockable};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class User extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{
    use Lockable, IsOnline, Endtime, UrlManagement, StorageActions;

    /**
     * Create new Reset Password Request and process it
     */
    public function sendPasswordResetNotification(): void
    {
        (new Request\ResetPasswordRequest($this))->notify();
    }

    /**
     * Create new Magic Link Request and process it
     */
    public function sendMagicLinkNotification(): void
    {
        (new Request\MagicLinkRequest($this))->notify();
    }

    /**
     * @return string
     */
    public function getUnlockActionUrl(): string
    {
        $args = ['email' => $this->getEmail()];

        return $this->buildUrl('unlock', 'Locker', $args);
    }

    /**
     * @return string
     */
    public function getForgotPasswordFormUrl(): string
    {
        $args = ['predefinedEmail' => $this->getEmail()];

        return $this->buildUrl('showForgotForm', 'ForgotPassword', $args);
    }
}
