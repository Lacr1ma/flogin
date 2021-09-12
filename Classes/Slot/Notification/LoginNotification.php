<?php
declare(strict_types = 1);

namespace LMS\Flogin\Slot\Notification;

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

use LMS\Flogin\Domain\Model\User;
use Symfony\Component\HttpFoundation\Request;
use LMS\Flogin\Notification\AbstractNotificationSender;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class LoginNotification extends AbstractNotificationSender
{
    /**
     * Build the LoginNotification Template and email the user
     */
    public function send(User $user): void
    {
        if ($this->isDisabled()) {
            return;
        }

        $request = Request::createFromGlobals()->server->all();
        $receiver = [$user->getEmail() => $user->getUsername()];

        $this->sendViaMail($receiver, compact('user', 'request'));
    }

    /**
     * Check if user notification activated in the TypoScript area
     */
    protected function isDisabled(): bool
    {
        return (bool)$this->getSettings()['login.']['disabled'];
    }

    /**
     * {@inheritDoc}
     */
    protected function getSubject(): string
    {
        return $this->translate(
            $this->getSettings()['login.']['subject']
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getTemplateSuffix(): string
    {
        return 'Email/Login';
    }
}
