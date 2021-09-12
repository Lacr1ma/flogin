<?php
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

use LMS\Flogin\Domain\Repository\UserRepository;
use Symfony\Component\Console\{Command\Command, Input\InputInterface, Output\OutputInterface};

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class OnetimeAccountGarbageCollectorCommand extends Command
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        parent::__construct();

        $this->userRepository = $repository;
    }

    protected function configure(): void
    {
        $this->setDescription('Clear all one time accounts who have expired.');
    }

    /**
     * System finds all Backend Users who expired and delete them.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->userRepository
            ->expiredQuery()
            ->delete('fe_users')
            ->execute();

        return 0;
    }
}
