<?php
declare(strict_types = 1);

namespace LMS\Login\Domain\Repository;

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

use LMS\Login\Support\TypoScript;
use Tightenco\Collect\Support\Collection;
use LMS\Login\{Hash\Hash, Domain\Model\User, Support\Repository\Demandable};
use LMS3\Support\{Repository\StaticCreation, Repository\CRUD as ProvidesCRUDActions};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
{
    use ProvidesCRUDActions, StaticCreation, Demandable;

    /**
     * {@inheritDoc}
     */
    public function initializeObject(): void
    {
        $settings = $this->createQuery()->getQuerySettings()->setStoragePageIds([
            TypoScript::getStoragePid('')
        ]);

        $this->setDefaultQuerySettings($settings);
    }

    /**
     * Retrieve logged in user
     *
     * @return \LMS\Login\Domain\Model\User|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function current(): ?User
    {
        return $this->findByUid(\LMS3\Support\Extbase\User::currentUid());
    }

    /**
     * Attempt to find a user by it's username
     *
     * @param string $name
     *
     * @return \LMS\Login\Domain\Model\User|null
     * @noinspection PhpUndefinedMethodInspection
     */
    public function retrieveByUsername(string $name): ?User
    {
        return $this->findOneByUsername($name);
    }

    /**
     * Retrieve all locked users
     *
     * @return \Tightenco\Collect\Support\Collection
     * @noinspection PhpUndefinedMethodInspection
     */
    public function findLocked(): Collection
    {
        return collect(
            $this->findByLocked(true)->toArray()
        );
    }

    /**
     * Attempt to find a user by it's email address
     *
     * @param string $email
     *
     * @return \LMS\Login\Domain\Model\User|null
     * @noinspection PhpUndefinedMethodInspection
     */
    public function retrieveByEmail(string $email): ?User
    {
        return $this->findOneByEmail($email);
    }

    /**
     * Check if the passed <plain password> matches the <encrypted password> for the
     * requested user.
     *
     * @param \LMS\Login\Domain\Model\User $user
     * @param string                       $password
     *
     * @return bool
     */
    public function validatePassword(User $user, string $password): bool
    {
        return Hash::make()->getHashFactory()->checkPassword($password, $user->getPassword());
    }
}
