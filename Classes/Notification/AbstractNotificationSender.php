<?php
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Notification;

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

use TYPO3\CMS\Core\Mail\Mailer;
use LMS\Flogin\Support\TypoScript;
use TYPO3\CMS\Core\Mail\FluidEmail;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractNotificationSender
{
    protected Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends the email to proper location based on abstract functions
     */
    protected function sendViaMail(array $receiver, array $variables = []): void
    {
        $to = new Address(array_key_first($receiver) ?: '', array_shift($receiver));

        $mail = GeneralUtility::makeInstance(FluidEmail::class)
            ->to($to)
            ->format('html')
            ->subject($this->getSubject())
            ->setTemplate($this->getTemplateSuffix())
            ->assign('data', $variables)
            ->assign('headline', $this->getSubject());

        $this->mailer->send($mail);
    }

    /**
     * Retrieves the translation for the requested path
     */
    protected function translate(string $path, array $arguments = []): string
    {
        return LocalizationUtility::translate($path, null, $arguments) ?: '';
    }

    /**
     * Retrieves the TypoScript configuration related to email settings
     */
    protected function getSettings(): array
    {
        return TypoScript::getSettings()['email.'];
    }

    /**
     * The path starting from Template folder and ends with File folder
     */
    abstract protected function getTemplateSuffix(): string;

    /**
     * Build email subject for the notification
     */
    abstract protected function getSubject(): string;
}
