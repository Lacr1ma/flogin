<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional;

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

use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
abstract class BaseTest extends FunctionalTestCase
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

        Bootstrap::initializeLanguageObject();

        $this->loadFixtures();
    }

    protected function getTypoScriptArray(): array
    {
        return [
            'page.' => [
                'login' => '2'
            ],
            'redirect.' => [
                'afterLoginPage' => '5',
                'afterLogoutPage' => '12',
                'afterUnlockedPage' => '16',
                'alreadyAuthenticatedPage' => '425',
                'afterForgotPasswordNotificationSentPage' => '7',
                'afterResetPasswordFormSubmittedPage' => '11',
                'afterMagicLinkNotificationSentPage' => '14',
                'error.' => [
                    'whenTokenExpiredPage' => '9',
                    'whenTokenNotFoundPage' => '10',
                    'whenLockedPage' => '15'
                ]
            ],
            'throttling.' => [
                'maxAttempts' => '5',
                'decayMinutes' => '1',
                'lockIntervalInMinutes' => '10'
            ],
            'email.' => [
                'magicLink.' => [
                    'subject' => 'LLL:EXT:flogin/Resources/Private/Language/email.xlf:magic_link.subject',
                    'linkLifetimeInMinutes' => '6'
                ],
                'passwordResetRequest.' => [
                    'subject' => 'LLL:EXT:flogin/Resources/Private/Language/email.xlf:reset_password.subject',
                    'linkLifetimeInMinutes' => '5'
                ],
                'passwordUpdated.' => [
                    'subject' => 'LLL:EXT:flogin/Resources/Private/Language/email.xlf:update_password.subject'
                ],
                'lockout.' => [
                    'subject' => 'LLL:EXT:flogin/Resources/Private/Language/email.xlf:lockout.subject'
                ],
                'login.' => [
                    'disabled' => '0',
                    'subject' => 'LLL:EXT:flogin/Resources/Private/Language/email.xlf:login.subject'
                ]
            ]
        ];
    }

    /**
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    protected function loadFixtures(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/fe_users.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/fe_groups.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/sys_template.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/tt_content.xml');
    }
}
