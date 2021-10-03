<?php
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

use LMS\Flogin\Support\Redirect;
use TYPO3\CMS\Extbase\Validation\Error;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\Arguments;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractApiController extends ActionController
{
    protected Redirect $redirect;

    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Build proper error messages for outside use
     *
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function errorAction(): ResponseInterface
    {
        $errors = $this->parseErrors(
            $this->getControllerContext()->getArguments()
        );

        $body = (string)json_encode(compact('errors'));

        return $this->jsonResponse($body);
    }

    public function parseErrors(Arguments $args): array
    {
        $errors = [];

        foreach ($args->validate()->getFlattenedErrors() as $propertyName => $propertyErrors) {
            /** @var Error $error */
            foreach ($propertyErrors as $error) {
                $errors[$propertyName] = $error->getMessage();
            }
        }

        return $errors;
    }
}
