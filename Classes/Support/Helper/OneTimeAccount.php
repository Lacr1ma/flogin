<?php
declare(strict_types = 1);

namespace LMS\Login\Support\Helper;

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
use LMS\Facade\StaticCreator;
use LMS\Login\{Hash\Hash, Support\TypoScript};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class OneTimeAccount
{
    use StaticCreator;

    /**
     * Create one time account based on hash
     *
     * @param string $hash
     *
     * @return array
     */
    public function getCombinedProperties(string $hash): array
    {
        return array_merge(
            $this->getProperties($hash),
            $this->accountSettings()['properties.']
        );
    }

    /**
     * @param string $hash
     *
     * @return array
     */
    public function getProperties(string $hash): array
    {
        return [
            'pid' => 0,
            'username' => $hash,
            'endtime' => $this->calculateTerminationTime(),
            'email' => "{$hash}@example.com",
            'password' => Hash::encryptPassword($hash)
        ];
    }

    /**
     * @return int
     */
    protected function calculateTerminationTime(): int
    {
        $lifeTime = $this->accountSettings()['lifetimeInMinutes'];

        return Carbon::now()->addMinutes($lifeTime)->timestamp;
    }

    /**
     * Retrieve one time account related settings
     *
     * @return array
     */
    protected function accountSettings(): array
    {
        return (array)TypoScript::getSettings()['oneTimeAccount.'];
    }
}
