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

$ll = 'LLL:EXT:login/Resources/Private/Language/tca_resets.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'resets',
        'label' => 'user',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'hideTable' => true,
        'iconfile' => 'EXT:login/Resources/Public/Icons/TCA/Link.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'user, token'
    ],
    'types' => [
        '1' => [
            'showitem' => '
                user, token, crdate
            '
        ]
    ],
    'columns' => [
        'user' => [
            'exclude' => true,
            'label' => $ll . 'user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users'
            ]
        ],
        'token' => [
            'exclude' => true,
            'label' => $ll . 'token',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'crdate' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ]
    ]
];
