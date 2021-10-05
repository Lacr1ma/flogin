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

use \LMS\Flogin\Controller\Backend\ManagementController;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Flogin',
    'web',
    'login',
    'bottom',
    [
        ManagementController::class => 'index, createOneTimeAccountHash'
    ],
    [
        'icon' => 'typo3conf/ext/flogin/ext_icon.svg',
        'access' => 'admin',
        'labels' => 'LLL:EXT:flogin/Resources/Private/Language/locallang_mod.xlf'
    ]
);
