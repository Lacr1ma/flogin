<?php
declare(strict_types = 1);

namespace LMS\Flogin\Domain\Model\Request;

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
use LMS\Flogin\Event\SessionEvent;
use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;
use LMS\Flogin\Support\Domain\{Property\Token, Action\User\UrlManagement};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress InternalClass
 *
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractRequest extends AbstractValueObject
{
    use Token, SessionEvent, UrlManagement;

    protected User $user;

    /**
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->token = md5(random_bytes(64));
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Build the URL that associated to current request action
     */
    abstract public function getUrl(): string;

    /**
     * Fires the appropriate event message.
     * After that we dispatch that message in a corresponding SLOT
     */
    abstract public function notify(): void;

    /**
     * Every request link has a lifetime.
     */
    abstract public function getExpires(): int;
}
