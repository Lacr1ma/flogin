<?php
/** @noinspection ALL */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Manager;

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

use TYPO3\CMS\Core\Context\Context;
use LMS\Flogin\Manager\SessionManager;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Session\UserSessionManager;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class SessionManagerTest extends FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/flogin', 'typo3conf/ext/routes'];

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
    public function fe_session_can_be_terminated(): void
    {
        $user = BackendUtility::getRecord('fe_users', 1);

        $context = new Context();
        $GLOBALS['TSFE'] = static::getMockBuilder(TypoScriptFrontendController::class)
            ->disableOriginalConstructor()
            ->getMock();

        $GLOBALS['TSFE']->fe_user = new FrontendUserAuthentication();
        $GLOBALS['TSFE']->fe_user->initializeUserSessionManager();

        $session = $GLOBALS['TSFE']->fe_user->createUserSession($user);

        $this->assertNotEmpty($session->getUserId());

        $this->getContainer()->get(SessionManager::class)->terminateFrontendSession(1);

        $manager = UserSessionManager::create('FE');
        $this->assertFalse($manager->isSessionPersisted($session));
    }
}
