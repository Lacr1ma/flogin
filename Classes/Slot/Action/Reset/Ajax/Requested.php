<?php
declare(strict_types = 1);

namespace LMS\Flogin\Slot\Action\Reset\Ajax;

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
use LMS\Facade\Extbase\{Redirect, Response};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Requested
{
    /**
     * Send back a proper redirect feedback for async usage mode.
     */
    public function execute(): void
    {
        if (!Response::isJson()) {
            return;
        }

        echo json_encode($this->responseData());

        exit;
    }

    /**
     * @return array
     */
    private function responseData(): array
    {
        return [
            'redirect' => Redirect::uriFor($this->redirectPage(), true)
        ];
    }

    /**
     * @return int
     */
    private function redirectPage(): int
    {
        return (int)TypoScript::getSettings()['redirect.']['afterResetPasswordFormSubmittedPage'];
    }
}
