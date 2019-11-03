<?php
declare(strict_types = 1);

namespace LMS\Login\Controller;

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

use LMS\Login\Domain\Model\Request\ResetPasswordRequest;
use LMS\Login\Support\Controller\ResetPassword\ResetsPasswords;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ResetPasswordController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    use ResetsPasswords;

    /**
     * By default mapping for <request> property is not activated,
     * so we activate it and allow creation process.
     */
    public function initializeShowResetFormAction(): void
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
     * This action gets called when user follows the <reset_link> from the email we sent before
     * There's a situation when token has been already expired or has been deleted by system,
     * so if any of these happened we simply redirect user to
     * <whenTokenExpiredPage> when token still exists in system but has been expired
     * <whenTokenNotFoundPage> when token has been already cleared out by scheduler.
     *
     * @param \LMS\Login\Domain\Model\Request\ResetPasswordRequest $request
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Login\Domain\Validator\ResetPassword\RequestValidator", param="request")
     */
    public function showResetFormAction(ResetPasswordRequest $request): void
    {
        $this->view->assign('request', $request);
    }

    /**
     * User has been submitted the new password and it's confirmation.
     * We check as before if request is still valid and also if password match
     *
     * @param \LMS\Login\Domain\Model\Request\ResetPasswordRequest $request
     * @TYPO3\CMS\Extbase\Annotation\Validate("LMS\Login\Domain\Validator\ResetPassword\AttemptValidator", param="request")
     */
    public function resetAction(ResetPasswordRequest $request): void
    {
        $this->reset($request);
    }
}
