<?php
declare(strict_types = 1);

namespace LMS\Login\Notification;

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

use LMS\Login\Support\TypoScript;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use LMS\Facade\{ObjectManageable, StaticCreator, Extbase\View\HtmlView};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractNotificationSender
{
    use HtmlView, StaticCreator;

    /**
     * Sends the email to proper location based on abstract functions
     *
     * @param array $receiver
     * @param array $variables
     */
    protected function sendViaMail(array $receiver, array $variables = []): void
    {
        $view = $this->getExtensionView($this->getTemplateSuffix(), $variables);

        $message = $this->getMessage()->setTo($receiver);

        $this->attachBody($message, $view->render())->send();
    }

    /**
     * Initialize Message Content
     *
     * @param \TYPO3\CMS\Core\Mail\MailMessage $msg
     * @param string                           $html
     *
     * @return \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected function attachBody(MailMessage $msg, string $html): MailMessage
    {
        if (method_exists($msg, 'html')) {
            return $msg->html($html);
        }

        return $msg->setBody($html, 'text/html');
    }

    /**
     * Create Mail Message
     *
     * @return \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected function getMessage(): MailMessage
    {
        return ObjectManageable::createObject(MailMessage::class)->setSubject($this->getSubject());
    }

    /**
     * Retrieves the translation for the requested path
     *
     * @param string $path
     * @param array  $arguments
     *
     * @return string
     */
    protected function translate(string $path, $arguments = []): string
    {
        return LocalizationUtility::translate($path, null, $arguments) ?: '';
    }

    /**
     * Retrieves the TypoScript configuration related to email settings
     *
     * @return array
     */
    protected function getSettings(): array
    {
        return TypoScript::getSettings()['email.'];
    }

    /**
     * The path starting from Template folder and ends with File folder
     *
     * @return string
     */
    abstract protected function getTemplateSuffix(): string;

    /**
     * Build email subject for the notification
     *
     * @return string
     */
    abstract protected function getSubject(): string;
}
