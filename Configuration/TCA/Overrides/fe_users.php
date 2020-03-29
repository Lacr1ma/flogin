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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility as Utility;

$ll = 'LLL:EXT:flogin/Resources/Private/Language/tca_user.xlf:';

$properties = [
    'locked' => [
        'exclude' => true,
        'label' => $ll . 'throttling',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxLabeledToggle',
            'items' => [
                [
                    0 => false,
                    1 => true,
                    'labelChecked' => $ll . 'throttling.inactive',
                    'labelUnchecked' => $ll . 'throttling.active',
                    'invertStateDisplay' => true
                ]
            ]
        ]
    ],
    'tstamp' => [
        'config' => [
            'type' => 'passthrough'
        ]
    ],
    'endtime' => [
        'config' => [
            'type' => 'passthrough'
        ]
    ],
    'is_online' => [
        'config' => [
            'type' => 'passthrough'
        ]
    ]
];

Utility::addTCAcolumns('fe_users', $properties);
Utility::addToAllTCAtypes(
    'fe_users',
    'locked',
    '',
    'after:disable'
);
