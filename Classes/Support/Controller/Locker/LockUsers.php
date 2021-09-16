<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support\Controller\Locker;

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

use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use LMS\Flogin\{Domain\Repository\UserRepository, Event\UserUnlockedEvent};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait LockUsers
{
    protected EventDispatcher $dispatcher;
    protected UserRepository $userRepository;

    public function injectUserRepository(UserRepository $repository, EventDispatcher $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
        $this->userRepository = $repository;
    }

    /**
     * Attempt to find associated to email user and unlock.
     * Fires the unlock event
     */
    public function unlock(string $email): void
    {
        if ($user = $this->userRepository->retrieveByEmail($email)) {
            $user->unlock();

            $this->dispatcher->dispatch(
                new UserUnlockedEvent($user)
            );
        }
    }
}
