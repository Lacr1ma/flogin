<?php
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

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

use LMS\Flogin\Domain\Model\Link;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class LinkRepository extends \LMS\Flogin\Domain\Repository\AbstractTokenRepository
{
    /**
     * Find magic link by its token
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
     * @noinspection PhpUndefinedMethodInspection
     * @psalm-suppress InvalidArgument
     * @return \LMS\Flogin\Domain\Model\Link[]
     */
    public function findActive(int $user): array
    {
        $userMagicLinks = $this->findByUser($user)->toArray();

        return array_filter($userMagicLinks, function (Link $link) {
            return $link->isExpired() === false;
        });
    }
}
