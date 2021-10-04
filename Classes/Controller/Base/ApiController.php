<?php
/** @noinspection PhpMissingFieldTypeInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Controller\Base;

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
use LMS\Flogin\Mvc\View\JsonView;
use TYPO3\CMS\Core\Context\Context;
use LMS\Flogin\Domain\Repository\UserRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class ApiController extends ActionController
{
    protected Context $context;
    protected Redirect $redirect;
    protected UserRepository $userRepository;

    /**
     * @var string
     */
    public $defaultViewObjectName = JsonView::class;

    public function injectStateContext(Context $ctx): void
    {
        $this->context = $ctx;
    }

    public function injectRedirectService(Redirect $service): void
    {
        $this->redirect = $service;
    }

    public function injectUserRepository(UserRepository $repository): void
    {
        $this->userRepository = $repository;
    }
}
