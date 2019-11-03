<?php
declare(strict_types = 1);

namespace LMS\Login\Controller\Backend;

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

use LMS\Login\Domain\Repository\UserRepository;
use LMS\Login\Guard\SessionGuard;
use LMS\Routes\Support\ObjectManageable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use In2code\Femanager\Utility\BackendUserUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Utility\EidUtility;
use TYPO3\CMS\Styleguide\TcaDataGenerator\TableHandler\General;


/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    use ObjectManageable;

    /**
     *
     */
    public function indexAction(): void
    {
        $this->view->assign('users', UserRepository::make()->findAll());
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     *
     * @return \Psr\Http\Message\ResponseInterface      $response
     */
    public function forceLoginAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $backendUser = BackendUserUtility::getBackendUserAuthentication()->user;

        if ($backendUser['admin'] !== 1) {
            return $response->withStatus(403);
        }

        $username = $request->getQueryParams()['username'];
        $password = $backendUser['ses_id'];

        $GLOBALS['TSFE'] = GeneralUtility::makeInstance(
            TypoScriptFrontendController::class,
            $GLOBALS['TYPO3_CONF_VARS'],
            0,
            1
        );

        $pid = (GeneralUtility::_GP('id') ? GeneralUtility::_GP('id') : 0);

        $GLOBALS['TSFE']->connectToDB();
        $GLOBALS['TSFE']->fe_user = EidUtility::initFeUser();
        $GLOBALS['TSFE']->id = $pid;
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->getConfigArray();

        $GLOBALS['BE_USER'] = $GLOBALS['TSFE']->initializeBackendUser();

        SessionGuard::make()->startCoreLogin($username, $password, false);

        return $response;
    }
}
