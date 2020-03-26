<?php
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

use LMS\Flogin\Support\Controller\ForgotPassword\SendsPasswordResetEmails;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class ForgotPasswordController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    use SendsPasswordResetEmails;

    /**
     * Renders the html form that contains only email field and submit button.
     * System uses the submitted email for sending the <reset password link> email.
     * There's an option when email could be already predefined, in that case we
     * set the passed $predefinedEmail inside a form.
     *
     * @param string $predefinedEmail
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\EmailValidator", param="predefinedEmail")
     */
    public function showForgotFormAction(string $predefinedEmail = ''): void
    {
        $this->view->assignMultiple(
            compact('predefinedEmail')
        );
    }

    /**
     * We check weather the submitted email really exists in the fe_users table
     * and send the email or redirect back with an error notification.
     *
     * @param string $email
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Flogin\Domain\Validator\EmailValidator", param="email")
     */
    public function sendResetLinkEmailAction(string $email): void
    {
        $this->sendResetLinkEmail($email);
    }
}
