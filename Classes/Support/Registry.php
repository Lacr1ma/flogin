<?php
declare(strict_types = 1);

namespace LMS\Flogin\Support;

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

use TYPO3\CMS\Core\Registry as CoreRegistry;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Registry
{
    protected CoreRegistry $registry;

    public function __construct(CoreRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function set(string $namespace, string $key, string $value): void
    {
        $this->registry->set($namespace, $key, $value);
    }

    public function remove(string $namespace, string $key): void
    {
        $this->registry->remove($namespace, $key);
    }

    public function contains(string $namespace, string $key): bool
    {
        return (bool)$this->registry->get($namespace, $key);
    }
}
