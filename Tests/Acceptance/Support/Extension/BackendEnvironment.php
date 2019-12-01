<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Acceptance\Support\Extension;

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
class BackendEnvironment extends \TYPO3\TestingFramework\Core\Acceptance\Extension\BackendEnvironment
{
    /**
     * @var array
     */
    protected $localConfig = [
        'coreExtensionsToLoad' => [
            'core',
            'fluid',
            'extbase',
            'backend',
            'install',
            'frontend',
            'recordlist',
            'scheduler',
            'fluid_styled_content'
        ],
        'testExtensionsToLoad' => [
            'typo3conf/ext/login',
            'typo3conf/ext/routes'
        ],
        'xmlDatabaseFixtures' => [
            'typo3conf/ext/login/Tests/Fixtures/Acceptance/pages.xml',
            'typo3conf/ext/login/Tests/Fixtures/Acceptance/fe_users.xml',
            'typo3conf/ext/login/Tests/Fixtures/Acceptance/fe_groups.xml',
            'typo3conf/ext/login/Tests/Fixtures/Acceptance/tt_content.xml',
            'typo3conf/ext/login/Tests/Fixtures/Acceptance/sys_template.xml',
            'PACKAGE:typo3/testing-framework/Resources/Core/Acceptance/Fixtures/be_users.xml',
            'PACKAGE:typo3/testing-framework/Resources/Core/Acceptance/Fixtures/be_groups.xml',
            'PACKAGE:typo3/testing-framework/Resources/Core/Acceptance/Fixtures/be_sessions.xml'
        ]
    ];
}
