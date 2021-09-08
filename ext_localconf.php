<?php

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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'flogin',
    'auth',
    LMS\Flogin\Service\MagicLinkAuthenticationService::class,
    [
        'title' => 'Magic Link Authentication Service',
        'description' => 'authentication for users based on Magic Link',
        'subtype' => 'authUserFE',
        'available' => true,
        'priority' => 80,
        'quality' => 80,
        'os' => '',
        'exec' => '',
        'className' => LMS\Flogin\Service\MagicLinkAuthenticationService::class,
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'flogin',
    'auth',
    LMS\Flogin\Service\BackendSimulationAuthenticationService::class,
    [
        'title' => 'Backend Simulation for the FE users.',
        'description' => 'allows site administrator to sign up using selected FE user.',
        'subtype' => 'authUserFE',
        'available' => true,
        'priority' => 82,
        'quality' => 82,
        'os' => '',
        'exec' => '',
        'className' => LMS\Flogin\Service\BackendSimulationAuthenticationService::class,
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'Flogin',
    [
        \LMS\Flogin\Controller\LoginController::class => 'showLoginForm, login, logout',
        \LMS\Flogin\Controller\ForgotPasswordController::class => 'showForgotForm, sendResetLinkEmail',
        \LMS\Flogin\Controller\MagicLinkController::class => 'showMagicLinkForm, sendMagicLinkEmail, login',
        \LMS\Flogin\Controller\ResetPasswordController::class => 'showResetForm, reset',
        \LMS\Flogin\Controller\LockerController::class => 'unlock'
    ],
    [
        \LMS\Flogin\Controller\LoginController::class => 'showLoginForm, login, logout',
        \LMS\Flogin\Controller\ForgotPasswordController::class => 'showForgotForm, sendResetLinkEmail',
        \LMS\Flogin\Controller\MagicLinkController::class => 'showMagicLinkForm, sendMagicLinkEmail, login',
        \LMS\Flogin\Controller\ResetPasswordController::class => 'showResetForm, reset',
        \LMS\Flogin\Controller\LockerController::class => 'unlock'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'UserApi',
    [
        \LMS\Flogin\Controller\UserApiController::class => 'list, create, edit, destroy, fail, current, authenticated, simulateLogin, terminateFrontendSession, createOneTimeAccount'
    ],
    [
        \LMS\Flogin\Controller\UserApiController::class => 'list, create, edit, destroy, fail, current, authenticated, simulateLogin, terminateFrontendSession, createOneTimeAccount'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'LoginApi',
    [
        \LMS\Flogin\Controller\Api\LoginApiController::class => 'showLoginForm, auth, logout'
    ],
    [
        \LMS\Flogin\Controller\Api\LoginApiController::class => 'showLoginForm, auth, logout'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'MagicLinkApi',
    [
        \LMS\Flogin\Controller\Api\MagicLinkApiController::class => 'sendMagicLinkEmail'
    ],
    [
        \LMS\Flogin\Controller\Api\MagicLinkApiController::class => 'sendMagicLinkEmail'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Flogin',
    'ForgotPasswordApi',
    [
       \LMS\Flogin\Controller\Api\ForgotPasswordApiController::class => 'sendResetLinkEmail'
    ],
    [
        \LMS\Flogin\Controller\Api\ForgotPasswordApiController::class => 'sendResetLinkEmail'
    ]
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_flogin'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_flogin'] = [];
}

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendResetLinkRequest',
    \LMS\Flogin\Slot\Action\Reset\Requested\CreateLink::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendResetLinkRequest',
    \LMS\Flogin\Slot\Action\Reset\Requested\SendNotification::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendResetLinkRequest',
    \LMS\Flogin\Slot\Action\Reset\Ajax\Requested::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendResetLinkRequest',
    \LMS\Flogin\Slot\Action\Reset\Requested\Redirect::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'passwordHasBeenReset',
    \LMS\Flogin\Slot\Action\Reset\Applied\Logoff::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'passwordHasBeenReset',
    \LMS\Flogin\Slot\Action\Reset\Applied\SendNotification::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'passwordHasBeenReset',
    \LMS\Flogin\Slot\Action\Reset\Applied\Redirect::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendMagicLinkRequest',
    \LMS\Flogin\Slot\Action\MagicLink\Requested\CreateLink::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendMagicLinkRequest',
    \LMS\Flogin\Slot\Action\MagicLink\Requested\SendNotification::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendMagicLinkRequest',
    \LMS\Flogin\Slot\Action\MagicLink\Ajax\Requested::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'sendMagicLinkRequest',
    \LMS\Flogin\Slot\Action\MagicLink\Requested\Redirect::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'magicLinkApplied',
    \LMS\Flogin\Slot\Action\MagicLink\Applied\UtilizeLink::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'lockout',
    \LMS\Flogin\Slot\Action\LockoutAction::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'userUnlocked',
    \LMS\Flogin\Slot\Action\Login\Success\ResetAttempts::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'userUnlocked',
    \LMS\Flogin\Slot\Action\Unlock\Redirect::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'loginAttempt',
    \LMS\Flogin\Slot\Action\Login\Attempt::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'loginAttemptFailed',
    \LMS\Flogin\Slot\Action\Login\Fail\IncrementAttempts::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'loginSuccess',
    \LMS\Flogin\Slot\Action\Login\Success\ResetAttempts::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'loginSuccess',
    \LMS\Flogin\Slot\Action\Login\Success\SendNotification::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'loginSuccess',
    \LMS\Flogin\Slot\Action\Login\Ajax\SuccessfulLoginAttempt::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'loginSuccess',
    \LMS\Flogin\Slot\Action\Login\Success\Redirect::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'logoutSuccess',
    \LMS\Flogin\Slot\Action\Logout\MarkInactive::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'logoutSuccess',
    \LMS\Flogin\Slot\Action\Login\Ajax\Logout::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Flogin\Event\SessionEvent::class,
    'logoutSuccess',
    \LMS\Flogin\Slot\Action\Logout\Redirect::class,
    'execute'
);
