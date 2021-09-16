<?php
/** @noinspection PhpUnused */

declare(strict_types = 1);

namespace LMS\Flogin\Support\Controller\Backend;

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

use LMS\Flogin\Support\Registry;
use LMS\Flogin\{Support\Helper\OneTimeAccount, Domain\Model\User, Guard\SessionGuard};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait CreatesOneTimeAccount
{
    protected Registry $registry;
    protected SessionGuard $guard;
    protected OneTimeAccount $oneTimeAccount;

    public function injectOneTimeAccount(OneTimeAccount $account): void
    {
        $this->oneTimeAccount = $account;
    }

    public function injectSessionsGuard(SessionGuard $guard): void
    {
        $this->guard = $guard;
    }

    public function injectRegistry(Registry $registry): void
    {
        $this->registry = $registry;
    }

    /**
     * Create one time account based on TypoScript settings
     *
     * @psalm-suppress MoreSpecificReturnType
     */
    public function createTemporaryFrontendAccount(string $hash): User
    {
        $this->registry->remove('tx_flogin_hash', $hash);

        return User::create(
            $this->oneTimeAccount->getCombinedProperties($hash)
        );
    }

    public function authorizeTemporaryUser(User $user, string $plainPassword): void
    {
        $this->guard->login($user, $plainPassword);
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     */
    protected function createOneTimeHash(): string
    {
        $value = md5(random_bytes(64));

        $this->registry->set('tx_flogin_hash', $value, '1');

        return $value;
    }
}
