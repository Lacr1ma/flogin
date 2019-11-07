<?php
declare(strict_types = 1);

namespace LMS\Login\Support\Domain\Property;

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

use Carbon\Carbon;
use LMS3\Support\Model\Property\CreationDate;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Expirable
{
    use CreationDate;

    /**
     * TRUE when entity has been already expired
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->getExpirationTime()->isPast();
    }

    /**
     * Get the exact time when entity expires
     *
     * @return \Carbon\Carbon
     */
    public function getExpirationTime(): Carbon
    {
        return $this->getCreatedAt()->addMinutes(
            $this->getLifetimeInMinutes()
        );
    }

    /**
     * Returns the number of minutes that token should be valid for
     *
     * @return int
     */
    abstract public static function getLifetimeInMinutes(): int;
}
