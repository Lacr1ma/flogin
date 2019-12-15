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

use LMS\Facade\Assist\Collection;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractTokenRepository extends \LMS\Facade\Repository\AbstractRepository
{
    /**
     * Find link related to requested token
     *
     * @param string $token
     *
     * @return object|null
     * @noinspection PhpUndefinedMethodInspection
     */
    public function find(string $token)
    {
        return $this->findOneByToken($token);
    }

    /**
     * Find all expired tokens in the system
     *
     * @return \LMS\Facade\Assist\Collection
     * @noinspection PhpUndefinedMethodInspection
     */
    public function findExpired(): Collection
    {
        return $this->all()->filter->isExpired();
    }

    /**
     * TRUE if entity with provided token does exist
     *
     * @param string $token
     *
     * @return bool
     */
    public function exists(string $token): bool
    {
        return $this->find($token) !== null;
    }
}
