<?php
/** @noinspection PhpComposerExtensionStubsInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Domain\Validator;

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

use Symfony\Component\HttpFoundation\Request;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use LMS\Flogin\Domain\{Model\User, Repository\UserRepository};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class DefaultValidator extends AbstractValidator
{
    /**
     * Mostly used for extracting username and password from the request.
     */
    protected function getRequestValue(string $name): string
    {
        if ($this->isJson() && $json = Request::createFromGlobals()->getContent()) {
            return json_decode((string)$json, true)[$name] ?: '';
        }

        return $this->requestProps()['tx_flogin_flogin'][$name] ?: '';
    }

    /**
     * Attempt to retrieve the <username> that has been sent thought the current HTTP Request
     */
    protected function getInputUserName(): string
    {
        return $this->getRequestValue('username');
    }

    /**
     * Attempt to retrieve the <password> that has been sent thought the current HTTP Request
     */
    protected function getInputPassword(): string
    {
        return $this->getRequestValue('password');
    }

    /**
     * Helper for getting proper translations inside parent relations
     */
    protected function translate(string $key, array $arguments = []): string
    {
        return $this->translateErrorMessage($key, 'flogin', $arguments) ?: '';
    }

    /**
     * Attempt to find user that is related to current login request
     */
    protected function findRequestAssociatedUser(): ?User
    {
        return UserRepository::make()->retrieveByUsername(
            $this->getInputUserName()
        );
    }

    protected function requestProps(): array
    {
        return Request::createFromGlobals()->request->all();
    }

    protected function isJson(): bool
    {
        $accepts = collect(Request::createFromGlobals()->getAcceptableContentTypes());

        return $accepts->contains('application/json');
    }
}
