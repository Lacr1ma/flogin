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
use LMS\Login\Support\TypoScript;
use LMS\Facade\Model\Property\UpdateDate;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Locked
{
    use UpdateDate;

    /**
     * @var bool
     */
    protected $locked;

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * @return bool
     */
    public function isNotLocked(): bool
    {
        return !$this->locked;
    }

    /**
     * @param bool $locked
     */
    public function setLocked(bool $locked): void
    {
        $this->locked = $locked;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getUnlockTime(): Carbon
    {
        return $this->getUpdatedAt()->addMinutes(self::getLockMinutesInterval());
    }

    /**
     * @return bool
     */
    public function isTimeToUnlock(): bool
    {
        return $this->getUnlockTime()->isPast();
    }

    /**
     * @return int
     */
    public static function getLockMinutesInterval(): int
    {
        return (int)TypoScript::getSettings()['throttling.']['lockIntervalInMinutes'];
    }
}
