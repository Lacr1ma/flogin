<?php
declare(strict_types = 1);

namespace LMS\Flogin\Controller\Backend;

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

use LMS\Flogin\Support\Controller\Backend\CreatesOneTimeAccount;
use LMS\Flogin\Domain\{Model\Demand, Repository\UserRepository};
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
class ManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    use CreatesOneTimeAccount;

    /**
     * Render table with existing FE users
     *
     * @param \LMS\Flogin\Domain\Model\Demand|null $demand
     */
    public function indexAction(Demand $demand = null, int $currentPage = 1): void
    {
        $demand = $demand ?: new Demand();

        $users = UserRepository::make()->findDemanded($demand);

        $paginator = new QueryResultPaginator($users, $currentPage, 3);
        $pagination = new SimplePagination($paginator);

        $this->view->assignMultiple([
            'demand' => $demand,
            'paginator' => $paginator,
            'pagination' => $pagination
        ]);
    }

    /**
     * Render form that contains generated link for account creation.
     *
     * @psalm-suppress UndefinedMethod
     */
    public function createOneTimeAccountHashAction(): void
    {
        $hash = $this->createOneTimeHash();

        $uri = $this->request->getUri();
        $baseUrl = "{$uri->getScheme()}://{$uri->getHost()}";

        $this->view->assign("url", "{$baseUrl}api/login/users/one-time-account/{$hash}?no_cache=1");
    }
}
