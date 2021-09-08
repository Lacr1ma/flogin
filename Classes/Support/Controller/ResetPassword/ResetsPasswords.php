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
use LMS\Flogin\Event\SessionEvent;
use LMS\Flogin\Domain\{Model\User, Model\Request\ResetPasswordRequest, Repository\ResetsRepository};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait ResetsPasswords
{
    use SessionEvent;

    /**
     * Attempt to reset the password and notify the listeners
     *
     * @param \LMS\Flogin\Domain\Model\Request\ResetPasswordRequest $request
     */
    public function reset(ResetPasswordRequest $request): void
    {
        $this->resetPassword($request->getUser(), $request->getPassword());

        $this->deleteAssociatedPasswordResetToken($request->getToken());

        $this->firePasswordResetEvent($request);
    }

    /**
     * Reset the given user's password.
     *
     * @param \LMS\Flogin\Domain\Model\User $user
     * @param string                       $newPlainPassword
     */
    private function resetPassword(User $user, string $newPlainPassword): void
    {
        $user->setPassword(
            Hash::encryptPassword($newPlainPassword)
        );

        $user->save();
    }

    /**
     * Erase reset token by it's hash
     *
     * @param string $token
     */
    private function deleteAssociatedPasswordResetToken(string $token): void
    {
        if ($token = ResetsRepository::make()->find($token)) {
            $token->delete();
        }
    }
}
