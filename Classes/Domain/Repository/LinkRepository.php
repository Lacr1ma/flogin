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

use LMS\Login\Domain\Model\Link;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class LinkRepository extends \LMS\Login\Domain\Repository\AbstractTokenRepository
{
    /**
     * Find magic link by it's token
     *
     *{@inheritDoc}
     * @noinspection   PhpIncompatibleReturnTypeInspection
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     */
    public function find(string $token): ?Link
    {
        return parent::find($token);
    }

    /**
     * Find all not expired magic links related to requested user
     *
     * @param int $user
     *
     * @return \LMS\Login\Domain\Model\Link[]
     * @noinspection PhpUndefinedMethodInspection
     */
    public function findActive(int $user): array
    {
        return array_filter($this->findByUser($user)->toArray(), function (Link $link) {
            return $link->isExpired() === false;
        });
    }
}
