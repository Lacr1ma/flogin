<?php
declare(strict_types = 1);

namespace LMS\Login\Support\Repository;

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

use LMS\Login\Domain\Model\Demand;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
trait Demandable
{
    /**
     * @param \LMS\Login\Domain\Model\Demand $demand
     *
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findDemanded(Demand $demand): QueryResult
    {
        $query = $this->createQuery();

        if ($username = $demand->getUsername()) {
            $query->matching($query->logicalAnd(
                $query->like('username', '%' . $username . '%')
            ));
        }

        return $query->execute();
    }
}
