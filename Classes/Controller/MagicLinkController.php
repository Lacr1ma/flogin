<?php
/** @noinspection PhpUnused */
/** @noinspection PhpDocSignatureIsNotCompleteInspection */
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

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

use LMS\Facade\Extbase\Redirect;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use LMS\Flogin\Domain\Model\Request\MagicLinkRequest;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;
use LMS\Flogin\Support\Controller\{Login\AuthenticatesUsers, MagicLink\SendsMagicLinkEmails};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class MagicLinkController extends ActionController
{
    use SendsMagicLinkEmails, AuthenticatesUsers;

    /**
     * By default, mapping for <request> property is not activated,
     * so we activate it and allow creation process.
     *
     * @psalm-suppress InternalMethod
     * @psalm-suppress InvalidScalarArgument
     */
    public function initializeLoginAction(): void
    {
        $this->arguments['request']->getPropertyMappingConfiguration()
            ->allowAllProperties()
            ->setTypeConverterOption(
                PersistentObjectConverter::class,
                PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
                true
            );
    }

    /**
     * Renders the html form that contains only email field and submit button.
     * System uses the submitted email for sending the <magic link> email.
     */
    public function showMagicLinkFormAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * We check weather the submitted email really exists in the fe_users table
     * and send the email or redirect back with an error notification.
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\EmailValidator", param="email")
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\MagicLink\NotAuthenticatedValidator", param="email")
     */
    public function sendMagicLinkEmailAction(string $email): ResponseInterface
    {
        $pid = (int)$this->settings['redirect']['afterMagicLinkNotificationSentPage'];

        $this->sendMagicLink($email);

        return new RedirectResponse(
            Redirect::uriFor($pid, true)
        );
    }

    /**
     * This action gets called when user follows the <magic_link> from the email we sent before
     * There's a situation when token has been already expired or has been deleted by system,
     * so if any of these happened we simply redirect user to
     * <whenTokenExpiredPage> when token still exists in system but has been expired
     * <whenTokenNotFoundPage> when token has been already cleared out by scheduler.
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\MagicLink\RequestValidator", param="request")
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\MagicLink\NotAuthenticatedValidator", param="request")
     */
    public function loginAction(MagicLinkRequest $request): ResponseInterface
    {
        $pid = (int)$this->settings['redirect']['afterLoginPage'];

        $credentials = [
            $request->getUser()->getUsername(),
            $request->getUser()->getPassword()
        ];

        $this->login($credentials);

        return new RedirectResponse(
            Redirect::uriFor($pid, true)
        );
    }
}
