<?php
/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Domain\Repository;

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

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use LMS\Flogin\{Domain\Model\User, Support\Repository\CRUD, Support\Repository\Demandable};

/**
 * @psalm-suppress InvalidArgument
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserRepository extends Repository
{
    use Demandable, CRUD;

    protected Context $context;
    protected ConnectionPool $connection;

    public function injectStateContext(Context $ctx): void
    {
        $this->context = $ctx;
    }

    public function injectConnection(ConnectionPool $connection): void
    {
        $this->connection = $connection;
    }

    public function initializeObject(): void
    {
        $settings = $this->createQuery()->getQuerySettings()->setRespectStoragePage(false);

        $this->setDefaultQuerySettings($settings);
    }

    /**
     * Retrieve logged in user
     *
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     * @noinspection   PhpIncompatibleReturnTypeInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function current(): ?User
    {
        $authUid = $this->context->getPropertyFromAspect('frontend.user', 'id');

        return $this->findByUid($authUid);
    }

    /**
     * Attempt to find a user by its username
     *
     * @psalm-suppress InvalidArgument
     * @noinspection PhpUndefinedMethodInspection
     */
    public function retrieveByUsername(string $name): ?User
    {
        return $this->findOneByUsername($name);
    }

    /**
     * Retrieve all locked users
     *
     * @return User[]
     */
    public function findLocked(): array
    {
        return $this->findByLocked(true)->toArray();
    }

    /**
     * Attempt to find a user by its email address
     *
     * @noinspection PhpUndefinedMethodInspection
     */
    public function retrieveByEmail(string $email): ?User
    {
        return $this->findOneByEmail($email);
    }

    /**
     * Predefined query that contains expired *where* clause.
     *
     * @noinspection PhpUndefinedMethodInspection
     */
    public function expiredQuery(): QueryBuilder
    {

        $query = $this->connection->getQueryBuilderForTable('fe_users');

        return $query->where(
            $query->expr()->gt('endtime', 0),
            $query->expr()->lt('endtime', time())
        );
    }
}
