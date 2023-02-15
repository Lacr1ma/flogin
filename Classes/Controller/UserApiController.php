<?php
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpComposerExtensionStubsInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Controller;

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

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use LMS\Flogin\Support\Controller\Backend\{CreatesOneTimeAccount, SimulatesFrontendLogin};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class UserApiController extends Base\ApiController
{
    use SimulatesFrontendLogin, CreatesOneTimeAccount;

    /**
     *  Return the data for currently authenticated user.
     */
    public function currentAction(): ResponseInterface
    {
        $authUid = (int)$this->context->getPropertyFromAspect('frontend.user', 'id');

        if ($user = $this->userRepository->findByUid($authUid)) {
            $json = (string)json_encode($user->_getProperties());
        }

        return $this->jsonResponse($json ?? '');
    }

    /**
     * Check if the requested user is being authenticated.
     */
    public function authenticatedAction(): ResponseInterface
    {
        $authenticated = $this->context->getPropertyFromAspect('frontend.user', 'isLoggedIn');

        $json = json_encode(compact('authenticated'));

        return $this->jsonResponse($json);
    }

    /**
     * Attempt to authenticate the requested user.
     */
    public function simulateLoginAction(string $username): ResponseInterface
    {
        $this->simulateLoginFor($username);

        return $this->responseFactory->createResponse();
    }

    /**
     * Logout a requested frontend user from all devices.
     */
    public function terminateFrontendSessionAction(int $user): ResponseInterface
    {
        $this->terminateSessionFor($user);

        return $this->responseFactory->createResponse();
    }

    /**
     * Attempt to create a temporary frontend user and authorize it.
     */
    public function createOneTimeAccountAction(string $hash): ResponseInterface
    {
        $pid = (int)$this->settings['redirect']['afterLoginPage'];

        if ($user = $this->createTemporaryFrontendAccount($hash)) {
            $this->authorizeTemporaryUser($user, $hash, $this->request);
        }

        return new RedirectResponse(
            $this->redirect->uriFor($pid, true)
        );
    }
}
