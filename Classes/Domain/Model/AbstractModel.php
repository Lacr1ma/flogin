<?php
/** @noinspection PhpUnused */
/** @noinspection DuplicatedCode */
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpInternalEntityUsedInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Domain\Model;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ClassNamingUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\RepositoryInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author         Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractModel extends AbstractEntity
{
    public static function settings(): array
    {
        return TypoScript::getSettings();
    }

    /**
     * @psalm-suppress InvalidStringClass
     */
    public static function repository(): RepositoryInterface
    {
        $repository = ClassNamingUtility::translateModelNameToRepositoryName(get_called_class());

        return GeneralUtility::makeInstance($repository);
    }

    /**
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public static function create(array $properties = []): self
    {
        $repository = self::repository();

        if (!isset($properties['pid']) && method_exists($repository, 'getPid')) {
            $properties['pid'] = $repository->getPid();
        }

        if (!isset($properties['crdate'])) {
            $properties['crdate'] = time();
        }

        $entity = $repository->produce($properties);

        $entity->save();

        return $entity;
    }

    /**
     * Persists the new entity or updates it
     *
     * @psalm-suppress InternalMethod
     * @psalm-suppress UndefinedInterfaceMethod
     * @noinspection PhpUndefinedMethodInspection
     */
    public function save(): void
    {
        $this->_isNew() ?
            self::repository()->persist($this) : self::repository()->upgrade($this);
    }

    /**
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function delete(): bool
    {
        return self::repository()->destroy($this);
    }
}
