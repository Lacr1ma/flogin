<?php
declare(strict_types = 1);

namespace LMS\Login\Support\Domain\Action\User;

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

use LMS\Login\Support\TypoScript;
use LMS3\Support\Extbase\Redirect;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait UrlManagement
{
    /**
     * @param string $action
     * @param string $controller
     * @param array  $arguments
     *
     * @return string
     */
    public function buildUrl(string $action, string $controller, array $arguments = []): string
    {
        $extension = $plugin = 'Login';

        return self::urlBuilder()->uriFor($action, $arguments, $controller, $extension, $plugin);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder
     */
    private static function urlBuilder(): UriBuilder
    {
        $loginPage = TypoScript::getSettings()['page.']['login'];

        return Redirect::uriBuilder()
            ->setCreateAbsoluteUri(true)
            ->setTargetPageUid($loginPage);
    }
}
