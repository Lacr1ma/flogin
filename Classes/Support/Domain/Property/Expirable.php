<?php
/** @noinspection SpellCheckingInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Support\Domain\Property;

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

use DateTime;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Expirable
{
    use CreationDate;

    /**
     * TRUE when entity has been already expired
     */
    public function isExpired(): bool
    {
        return new DateTime() > $this->getExpirationTime();
    }

    /**
     * Get the exact time when entity expires
     */
    public function getExpirationTime(): DateTime
    {
        $interval = $this->getLifetimeInMinutes();

        return $this->getCreatedAt()->modify("+{$interval} minutes");
    }

    /**
     * Returns the number of minutes that token should be valid for
     */
    abstract public static function getLifetimeInMinutes(): int;
}
