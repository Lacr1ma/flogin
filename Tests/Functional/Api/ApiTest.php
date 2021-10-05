<?php
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Tests\Functional\Api;

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

use Exception;
use LogicException;
use LMS\Flogin\Tests\Functional\BaseTest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\SiteConfiguration;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalResponse;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequestContext;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class ApiTest extends BaseTest
{
    protected const LANGUAGE_PRESETS = [
        'EN' => ['id' => 0, 'title' => 'English', 'locale' => 'en_US.UTF8', 'iso' => 'en', 'hrefLang' => 'en-US', 'direction' => ''],
    ];

    protected function writeSiteConfiguration(string $identifier, array $site = [], array $languages = [], array $errorHandling = []): void {
        $configuration = $site;
        if (!empty($languages)) {
            $configuration['languages'] = $languages;
        }
        if (!empty($errorHandling)) {
            $configuration['errorHandling'] = $errorHandling;
        }
        $siteConfiguration = new SiteConfiguration(
            $this->instancePath . '/typo3conf/sites/',
            $this->getContainer()->get('cache.core')
        );

        try {
            // ensure no previous site configuration influences the test
            GeneralUtility::rmdir($this->instancePath . '/typo3conf/sites/' . $identifier, true);
            $siteConfiguration->write($identifier, $configuration);
        } catch (Exception $exception) {
            $this->markTestSkipped($exception->getMessage());
        }
    }

    protected function buildSiteConfiguration(int $rootPageId, string $base = ''): array
    {
        return [
            'rootPageId' => $rootPageId,
            'base' => $base,
        ];
    }

    protected function buildDefaultLanguageConfiguration(string $identifier, string $base): array
    {
        $configuration = $this->buildLanguageConfiguration($identifier, $base);
        $configuration['typo3Language'] = 'default';
        $configuration['flag'] = 'global';
        unset($configuration['fallbackType'], $configuration['fallbacks']);
        return $configuration;
    }

    protected function resolveLanguagePreset(string $identifier): array
    {
        if (!isset(static::LANGUAGE_PRESETS[$identifier])) {
            throw new LogicException(
                sprintf('Undefined preset identifier "%s"', $identifier),
                1533893665
            );
        }
        return static::LANGUAGE_PRESETS[$identifier];
    }

    protected function buildLanguageConfiguration(string $identifier, string $base, array $fallbackIdentifiers = [], string $fallbackType = null): array
    {
        $preset = $this->resolveLanguagePreset($identifier);

        $configuration = [
            'languageId' => $preset['id'],
            'title' => $preset['title'],
            'navigationTitle' => $preset['title'],
            'base' => $base,
            'locale' => $preset['locale'],
            'iso-639-1' => $preset['iso'],
            'hreflang' => $preset['hrefLang'],
            'direction' => $preset['direction'],
            'typo3Language' => $preset['iso'],
            'flag' => $preset['iso'],
            'fallbackType' => $fallbackType ?? (empty($fallbackIdentifiers) ? 'strict' : 'fallback'),
        ];

        if (!empty($fallbackIdentifiers)) {
            $fallbackIds = array_map(
                function (string $fallbackIdentifier) {
                    $preset = $this->resolveLanguagePreset($fallbackIdentifier);
                    return $preset['id'];
                },
                $fallbackIdentifiers
            );
            $configuration['fallbackType'] = $fallbackType ?? 'fallback';
            $configuration['fallbacks'] = implode(',', $fallbackIds);
        }

        return $configuration;
    }

    private function setEnv(): void
    {
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:flogin/Tests/Fixtures/Acceptance/root_page.typoscript'
            ]
        );

        $this->writeSiteConfiguration(
            'test',
            $this->buildSiteConfiguration(1, 'http://login.ddev.site/'),
            [
                $this->buildDefaultLanguageConfiguration('EN', '/'),
            ]
        );
    }

    private function callEndpoint(string $slug): InternalResponse
    {
        $this->setEnv();

        $csrf = FormProtectionFactory::get()
            ->generateToken('routes', 'api',1);

        $request = (new InternalRequest('http://login.ddev.site/api/' . $slug))
            ->withPageId(1)
            ->withAddedHeader('X-CSRF-TOKEN', $csrf);

        $context = (new InternalRequestContext())
            ->withFrontendUserId(1)
            ->withBackendUserId(1);

        return $this->executeFrontendSubRequest($request, $context, true);
    }

    /**
     * @test
     */
    public function logout_is_working(): void
    {
        $response = $this->callEndpoint('login/logins/logout');

        $this->assertStringContainsString('redirect', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function proper_hash_is_required_for_account_creation(): void
    {
        $response = $this->callEndpoint('login/users/one-time-account/invalid-hash');

        $this->assertNotEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function user_info_present_when_user_authenticated(): void
    {
        $response = $this->callEndpoint('login/users/current');

        $this->assertStringContainsString('user@example.com', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function authenticated_returns_false_when_user_not_logged_in(): void
    {
        $this->setEnv();

        $request = (new InternalRequest('http://login.ddev.site/api/login/users/authenticated'))
            ->withPageId(1);

        $context = (new InternalRequestContext());

        $body = (string) $this->executeFrontendSubRequest($request, $context)
            ->getBody();

        $this->assertStringContainsString('"authenticated":false', $body);
    }

    /**
     * @test
     */
    public function authenticated_returns_true_when_user_logged_in(): void
    {
        $response = $this->callEndpoint('login/users/authenticated');

        $this->assertStringContainsString('"authenticated":true', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function backend_user_session_required_for_simulate(): void
    {
        $response = $this->callEndpoint('login/users/simulate/user-name');

        $this->assertStringContainsString('Admin user is required', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function simulation_is_working_when_admin_session_is_present(): void
    {
        $this->importDataSet(__DIR__ . '/../../Fixtures/Acceptance/be_users.xml');

        $response = $this->callEndpoint('login/users/simulate/user-name');

        $this->assertStringNotContainsString('Admin user is required', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function backend_user_session_required_for_terminate(): void
    {
        $response = $this->callEndpoint('login/users/terminate/2');

        $this->assertStringContainsString('Admin user is required', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function backend_user_session_can_be_terminated_when_admin_session_is_present(): void
    {
        $this->importDataSet(__DIR__ . '/../../Fixtures/Acceptance/be_users.xml');

        $response = $this->callEndpoint('login/users/terminate/2');

        $this->assertStringNotContainsString('Admin user is required', (string)$response->getBody());
    }
}
