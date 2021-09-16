<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support\Controller\ResetPassword;

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

use LMS\Flogin\Hash\Hash;
use LMS\Flogin\Event\PasswordHasBeenResetEvent;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use LMS\Flogin\Domain\{Model\User, Model\Request\ResetPasswordRequest, Repository\ResetsRepository};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait ResetsPasswords
{
    protected Hash $hash;
    protected EventDispatcher $dispatcher;
    protected ResetsRepository $resetsRepository;

    public function injectResetsRepository(ResetsRepository $repository, Hash $hash, EventDispatcher $dispatcher): void
    {
        $this->hash = $hash;
        $this->dispatcher = $dispatcher;
        $this->resetsRepository = $repository;
    }

    /**
     * Attempt to reset the password and notify the listeners
     */
    public function reset(ResetPasswordRequest $request): void
    {
        $this->resetPassword($request->getUser(), $request->getPassword());

        $this->deleteAssociatedPasswordResetToken($request->getToken());

        $this->dispatcher->dispatch(
            new PasswordHasBeenResetEvent($request)
        );
    }

    private function resetPassword(User $user, string $newPlainPassword): void
    {
        $user->setPassword(
           $this->hash->encryptPassword($newPlainPassword)
        );

        $user->save();
    }

    private function deleteAssociatedPasswordResetToken(string $token): void
    {
        if ($token = $this->resetsRepository->find($token)) {
            $token->delete();
        }
    }
}
