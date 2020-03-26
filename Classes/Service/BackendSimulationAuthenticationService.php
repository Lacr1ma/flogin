<?php
declare(strict_types = 1);

namespace LMS\Flogin\Service;

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

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class BackendSimulationAuthenticationService extends \TYPO3\CMS\Core\Authentication\AbstractAuthenticationService
{
    /**
     * 100 - Try to authenticate user by next service
     *
     * @var int
     */
    const STATUS_AUTHENTICATION_CONTINUE = 100;

    /**
     * 200 - authenticated and no more checking needed
     *
     * @var int
     */
    const STATUS_AUTHENTICATION_SUCCESS = 200;

    /**
     * {@inheritDoc}
     */
    public function authUser(array $user): int
    {
        if ($_POST['be_user']['ses_id'] === $GLOBALS['BE_USER']->id) {
            return self::STATUS_AUTHENTICATION_SUCCESS;
        }

        return self::STATUS_AUTHENTICATION_CONTINUE;
    }
}
