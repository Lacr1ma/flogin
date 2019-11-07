<?php

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

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
    ->registerImplementation(
        \TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class,
        \LMS\Login\Domain\Model\User::class
    );

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
    ->registerImplementation(
        \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup::class,
        \LMS\Login\Domain\Model\UserGroup::class
    );

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
    ->registerImplementation(
        \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository::class,
        \LMS\Login\Domain\Repository\UserRepository::class
    );

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
    ->registerImplementation(
        \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository::class,
        \LMS\Login\Domain\Repository\UserGroupRepository::class
    );

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'LMS.Login',
    'web',
    'login',
    'bottom',
    [
        'Backend\Management' => 'index, forceLogin'
    ],
    [
        'icon' => 'EXT:login/ext_icon.svg',
        'access' => 'admin',
        'labels' => 'LMS: Login'
    ]
);

