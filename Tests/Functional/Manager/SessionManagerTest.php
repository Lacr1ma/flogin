<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Manager;

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

use LMS\Login\Manager\SessionManager;
use TYPO3\CMS\Frontend\Utility\EidUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class SessionManagerTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/login'];

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/../../Fixtures/Acceptance/fe_users.xml');
    }

    /**
     * @test
     */
    public function manager_instance_created(): void
    {
        $this->assertNotEmpty(SessionManager::manager());
    }

    /**
     * @test
     */
    public function fe_session_initialized(): void
    {
        $this->assertNotEmpty(SessionManager::frontendSession());
    }

    /**
     * EidUtility is deprecated, but for now we can accept that
     *
     * @test
     */
    public function fe_session_can_be_terminated(): void
    {
        $user = BackendUtility::getRecord('fe_users', 1);

        $GLOBALS['TSFE']->fe_user = EidUtility::initFeUser();
        $GLOBALS['TSFE']->fe_user->createUserSession($user);
        $GLOBALS['TSFE']->fe_user->user = $GLOBALS['TSFE']->fe_user->fetchUserSession();
        $GLOBALS['TSFE']->fe_user->setAndSaveSessionData('ses', true);

        $this->assertNotEmpty($GLOBALS['TSFE']->fe_user->fetchUserSession(true));

        SessionManager::terminateFrontendSession(1);

        $this->assertFalse($GLOBALS['TSFE']->fe_user->fetchUserSession(true));
    }
}
