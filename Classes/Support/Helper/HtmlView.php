<?php
/** @noinspection PhpInternalEntityUsedInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Support\Helper;

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
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait HtmlView
{
    public function getExtensionView(string $template, array $variables = []): StandaloneView
    {
        $view = $this->createView();

        $viewTS = TypoScript::getView();

        $settings = $this->typoScriptService()->convertTypoScriptArrayToPlainArray(
            TypoScript::getSettings()
        );

        $view->setFormat('html');
        $view->setLayoutRootPaths($viewTS['layoutRootPaths.'] ?: []);
        $view->setPartialRootPaths($viewTS['partialRootPaths.'] ?: []);
        $view->setTemplateRootPaths($viewTS['templateRootPaths.'] ?: []);
        $view->setTemplate($template);

        return $view->assignMultiple(array_merge($settings, $variables));
    }

    protected function typoScriptService(): TypoScriptService
    {
        return GeneralUtility::makeInstance(TypoScriptService::class);
    }

    protected function createView(): StandaloneView
    {
        return GeneralUtility::makeInstance(StandaloneView::class);
    }
}
