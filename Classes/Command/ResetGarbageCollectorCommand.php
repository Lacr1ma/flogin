<?php
/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types = 1);

namespace LMS\Flogin\Command;

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

use LMS\Flogin\Domain\Repository\ResetsRepository;
use Symfony\Component\Console\{Command\Command, Input\InputInterface, Output\OutputInterface};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class ResetGarbageCollectorCommand extends Command
{
    private ResetsRepository $passwordRepository;

    public function __construct(ResetsRepository $repository)
    {
        parent::__construct();

        $this->passwordRepository = $repository;
    }

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function configure(): void
    {
        $this->setDescription('Clear all expired reset password links');
    }

    /**
     * System finds all expired <reset_links> and deletes them
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->passwordRepository->findExpired()->map->delete();

        return 0;
    }
}
