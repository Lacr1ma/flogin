<?php
declare(strict_types = 1);

namespace LMS\Flogin\Slot\Action\Login\Success;

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

use LMS\Flogin\Event\LoginSuccessEvent;
use LMS\Flogin\Slot\Notification\LoginNotification;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class SendNotification
{
    protected LoginNotification $notification;

    public function __construct(LoginNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Successful login attempt detected, send user notification
     */
    public function __invoke(LoginSuccessEvent $e): void
    {
        $this->notification->send($e->receiver());
    }
}
