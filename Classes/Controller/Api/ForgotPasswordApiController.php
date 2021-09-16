<?php
/** @noinspection PhpDocSignatureIsNotCompleteInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Controller\Api;

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
use LMS\Flogin\Support\Controller\ForgotPassword\SendsPasswordResetEmails;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class ForgotPasswordApiController extends AbstractApiController
{
    use SendsPasswordResetEmails;

    /**
     * We check weather the submitted email really exists in the fe_users table
     * and send the email or redirect back with an error notification.
     *
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\EmailValidator", param="email")
     */
    public function sendResetLinkEmailAction(string $email): ResponseInterface
    {
        $pid = (int)$this->settings['redirect']['afterResetPasswordFormSubmittedPage'];

        $this->sendResetLinkEmail($email);

        $redirect = $this->redirect->uriFor($pid, true);

        return $this->jsonResponse(
            collect(compact('redirect'))->toJson()
        );
    }
}
