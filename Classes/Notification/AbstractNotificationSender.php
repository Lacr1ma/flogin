<?php
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

use LMS\Flogin\Support\TypoScript;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Mail\MailMessage;
use LMS\Flogin\Support\Helper\HtmlView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractNotificationSender
{
    use HtmlView;

    protected MailMessage $mail;

    public function __construct(MailMessage $message)
    {
        $this->mail = $message;
    }

    /**
     * Sends the email to proper location based on abstract functions
     */
    protected function sendViaMail(array $receiver, array $variables = []): void
    {
        $view = $this->getExtensionView($this->getTemplateSuffix(), $variables);
        $html = $this->applyStyles($view->render());

        $this->mail
            ->setSubject($this->getSubject())
            ->setTo($receiver)
            ->html($html)
            ->send();
    }

    protected function applyStyles(string $html): string
    {
        $css = GeneralUtility::makeInstance(CssToInlineStyles::class);

        $cssPath = Environment::getPublicPath() . '/' . $this->getSettings()['stylesPath'];

        return $css->convert($html, file_get_contents($cssPath));
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
