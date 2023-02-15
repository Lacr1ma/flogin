<?php
declare(strict_types = 1);

namespace LMS\Flogin\Event;

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
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Borulko Serhii <borulkosergey@icloud.com>
 */
final class LoginAttemptEvent
{
    /**
     * Who's a notification receiver?
     */
    private User $receiver;
    private ServerRequestInterface $request;

    /**
     * Should we remember the session?
     */
    private bool $remember;

    /**
     * Password in a plain form.
     */
    private string $password;

    public function __construct(User $user, string $plainPassword, bool $remember, ServerRequestInterface $request)
    {
        $this->receiver = $user;
        $this->remember = $remember;
        $this->password = $plainPassword;
        $this->request = $request;
    }

    public function receiver(): User
    {
        return $this->receiver;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function isRememberable(): bool
    {
        return $this->remember;
    }

    public function request(): ServerRequestInterface
    {
        return $this->request;
    }
}
