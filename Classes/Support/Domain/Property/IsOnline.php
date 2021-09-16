<?php
/** @noinspection DuplicatedCode */
/** @noinspection PhpUndefinedMethodInspection */

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

use Carbon\Carbon;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait IsOnline
{
    protected int $isOnline = 0;

    public function resetOnlineTime(): void
    {
        $this->isOnline = 0;
    }

    public function getOnline(): bool
    {
        return $this->hasActiveSession() || $this->wasActiveRecently();
    }

    /**
     * @psalm-suppress PossiblyInvalidMethodCall
     * @psalm-suppress InternalMethod
     */
    public function hasActiveSession(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class);

        $builder = $connection->getQueryBuilderForTable('fe_sessions');

        $where = [$builder->expr()->eq('ses_userid', $this->getUid())];

        return (bool)$builder->count('ses_userid')->from('fe_sessions')->where(...$where)->execute()->fetchColumn();
    }

    public function wasActiveRecently(): bool
    {
        return $this->isOnline > 0 && Carbon::createFromTimestamp($this->isOnline)->diffInMinutes(Carbon::now()) <= 1;
    }
}
