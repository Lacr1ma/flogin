<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Acceptance\Support;

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

use LMS\Flogin\Tests\Acceptance\Support\_generated\AcceptanceTesterActions;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class AcceptanceTester extends \Codeception\Actor
{
    use AcceptanceTesterActions;

    public function amOnForgotPage(): void
    {
        $this->amOnPage('/login');
        $this->click('#forgot-link');
    }

    public function amOnMagicLinkPage(): void
    {
        $this->amOnPage('/login');
        $this->click('#magic-link');
    }

    /**
     * @param string $toEmail
     */
    public function amRequestingPasswordResetNotification(string $toEmail): void
    {
        $this->deleteAllEmails();
        $this->fetchEmails();

        $this->amOnForgotPage();
        $this->fillField('tx_flogin_flogin[email]', $toEmail);
        $this->click('#send-reset-link');
    }

    /**
     * @param string $toEmail
     */
    public function amRequestingMagicLinkNotification(string $toEmail): void
    {
        $this->deleteAllEmails();
        $this->fetchEmails();

        $this->amOnMagicLinkPage();
        $this->fillField('tx_flogin_flogin[email]', $toEmail);
        $this->click('#send-magic-link');
    }

    /**
     * @param string $email
     */
    public function amOnResetPasswordPageRelatedTo(string $email): void
    {
        $this->amRequestingPasswordResetNotification($email);

        $this->amOnUrl(
            $this->extractLinkFromLastMail()
        );
    }

    /**
     * @return string
     */
    public function extractLinkFromLastMail(): string
    {
        $this->fetchEmails();
        $this->openNextUnreadEmail();

        preg_match('/<a(.*?)href="([^"]+)"(.*?)>/i', $this->grabBodyFromEmail(), $match);

        return htmlspecialchars_decode($match[2]) ?: '';
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $confirmation
     * @param bool   $clearInbox
     */
    public function amChangingPassword(string $email, string $password, string $confirmation, bool $clearInbox = true): void
    {
        $this->amOnResetPasswordPageRelatedTo($email);

        if ($clearInbox) {
            $this->deleteAllEmails();
            $this->fetchEmails();
        }

        $this->fillField('tx_flogin_flogin[request][password]', $password);
        $this->fillField('tx_flogin_flogin[request][passwordConfirmation]', $confirmation);
        $this->click('#change-password-link');
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function amLoggedInAs(string $username = 'dummy', string $password = 'password'): void
    {
        $this->amOnPage('/login');

        $this->fillField('tx_flogin_flogin[username]', $username);
        $this->fillField('tx_flogin_flogin[password]', $password);
        $this->uncheckOption('tx_flogin_flogin[remember]', 0);

        $this->click('#login-button');
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function amLoggedByAjaxFormAs(string $username = 'dummy', string $password = 'password'): void
    {
        $this->amOnPage('/loginajax');

        $this->fillField('username', $username);
        $this->fillField('password', $password);
        $this->uncheckOption('remember', 0);

        $this->click('#login-button');
    }

    /**
     * @param string $email
     */
    public function amRequestingMagicLinkAjax(string $email): void
    {
        $this->amOnPage('/loginajax');

        $this->click('#magic-link');
        $this->fillField('email', $email);

        $this->click('#send-magic-link');
    }

    /**
     * @param string $email
     */
    public function amRequestingForgotLinkAjax(string $email): void
    {
        $this->amOnPage('/loginajax');

        $this->click('#forgot-link');
        $this->fillField('#forgot-email-field', $email);

        $this->click('#send-forgot-link');
    }
}
