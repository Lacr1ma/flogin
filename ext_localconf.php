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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    'auth',
    LMS\Login\Service\MagicLinkAuthenticationService::class,
    [
        'title' => 'Magic Link Authentication Service',
        'description' => 'authentication for users based on Magic Link',
        'subtype' => 'authUserFE',
        'available' => true,
        'priority' => 80,
        'quality' => 80,
        'os' => '',
        'exec' => '',
        'className' => LMS\Login\Service\MagicLinkAuthenticationService::class,
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    'auth',
    LMS\Login\Service\BackendSimulationAuthenticationService::class,
    [
        'title' => 'Backend Simulation for the FE users.',
        'description' => 'allows site administrator to sign up using selected FE user.',
        'subtype' => 'authUserFE',
        'available' => true,
        'priority' => 82,
        'quality' => 82,
        'os' => '',
        'exec' => '',
        'className' => LMS\Login\Service\BackendSimulationAuthenticationService::class,
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'LMS.' . $_EXTKEY,
    'Login',
    [
        'Login' => 'showLoginForm, login, logout',
        'ForgotPassword' => 'showForgotForm, sendResetLinkEmail',
        'MagicLink' => 'showMagicLinkForm, sendMagicLinkEmail, login',
        'ResetPassword' => 'showResetForm, reset',
        'Locker' => 'unlock'
    ],
    [
        'Login' => 'showLoginForm, login, logout',
        'ForgotPassword' => 'showForgotForm, sendResetLinkEmail',
        'MagicLink' => 'showMagicLinkForm, sendMagicLinkEmail, login',
        'ResetPassword' => 'showResetForm, reset',
        'Locker' => 'unlock'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'LMS.' . $_EXTKEY,
    'UserApi',
    [
        'UserApi' => 'list, create, edit, destroy, fail, current, authenticated, simulateLogin, terminateFrontendSession'
    ],
    [
        'UserApi' => 'list, create, edit, destroy, fail, current, authenticated, simulateLogin, terminateFrontendSession'
    ]
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_login'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_login'] = [];
}

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'sendResetLinkRequest',
    \LMS\Login\Slot\Action\Reset\LinkRequested::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'passwordHasBeenReset',
    \LMS\Login\Slot\Action\Reset\PasswordUpdated::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'sendMagicLinkRequest',
    \LMS\Login\Slot\Action\MagicLink\LinkRequested::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'MagicLinkApplied',
    \LMS\Login\Slot\Action\MagicLink\LinkApplied::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'lockout',
    \LMS\Login\Slot\Action\LockoutAction::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'userUnlocked',
    \LMS\Login\Slot\Action\UnlockedAction::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'loginAttempt',
    \LMS\Login\Slot\Action\Login\Attempt::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'loginAttemptFailed',
    \LMS\Login\Slot\Action\Login\FailedAttempt::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'loginSuccess',
    \LMS\Login\Slot\Action\Login\LoginSucceed::class,
    'execute'
);

$signalSlotDispatcher->connect(
    \LMS\Login\Event\SessionEvent::class,
    'logoutSuccess',
    \LMS\Login\Slot\Action\Login\Logout::class,
    'execute'
);
