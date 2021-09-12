<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types = 1);

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

defined('TYPO3') or die();

use LMS\Flogin\Controller\LoginController;
use LMS\Flogin\Controller\LockerController;
use LMS\Flogin\Controller\UserApiController;
use LMS\Flogin\Controller\MagicLinkController;
use LMS\Flogin\Controller\Api\LoginApiController;
use LMS\Flogin\Controller\ResetPasswordController;
use LMS\Flogin\Controller\ForgotPasswordController;
use LMS\Flogin\Controller\Api\MagicLinkApiController;
use LMS\Flogin\Controller\Api\ForgotPasswordApiController;
use LMS\Flogin\Service\BackendSimulationAuthenticationService;

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'flogin',
    'auth',
    BackendSimulationAuthenticationService::class,
    [
        'title' => 'Backend Simulation for the FE users.',
        'description' => 'allows site administrator to sign up using selected FE user.',
        'subtype' => 'authUserFE',
        'available' => true,
        'priority' => 82,
        'quality' => 82,
        'os' => '',
        'exec' => '',
        'className' => BackendSimulationAuthenticationService::class
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'Flogin',
    [
        LoginController::class => 'showLoginForm, login, logout',
        ForgotPasswordController::class => 'showForgotForm, sendResetLinkEmail',
        MagicLinkController::class => 'showMagicLinkForm, sendMagicLinkEmail, login',
        ResetPasswordController::class => 'showResetForm, reset',
        LockerController::class => 'unlock'
    ],
    [
        LoginController::class => 'showLoginForm, login, logout',
        ForgotPasswordController::class => 'showForgotForm, sendResetLinkEmail',
        MagicLinkController::class => 'showMagicLinkForm, sendMagicLinkEmail, login',
        ResetPasswordController::class => 'showResetForm, reset',
        LockerController::class => 'unlock'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'UserApi',
    [
        UserApiController::class => 'list, create, edit, destroy, fail, current, authenticated, simulateLogin, terminateFrontendSession, createOneTimeAccount'
    ],
    [
        UserApiController::class => 'list, create, edit, destroy, fail, current, authenticated, simulateLogin, terminateFrontendSession, createOneTimeAccount'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'LoginApi',
    [
        LoginApiController::class => 'showLoginForm, auth, logout'
    ],
    [
        LoginApiController::class => 'showLoginForm, auth, logout'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'MagicLinkApi',
    [
        MagicLinkApiController::class => 'sendMagicLinkEmail'
    ],
    [
        MagicLinkApiController::class => 'sendMagicLinkEmail'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'ForgotPasswordApi',
    [
       ForgotPasswordApiController::class => 'sendResetLinkEmail'
    ],
    [
        ForgotPasswordApiController::class => 'sendResetLinkEmail'
    ]
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_flogin'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_flogin'] = [];
}
