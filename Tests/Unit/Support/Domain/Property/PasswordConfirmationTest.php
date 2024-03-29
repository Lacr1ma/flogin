<?php
declare(strict_types = 1);

namespace LMS\Flogin\Tests\Unit\Support\Domain\Property;

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

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use LMS\Flogin\Support\Domain\Property\PasswordConfirmation as ContainsPasswordConfirmation;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class PasswordConfirmationTest extends UnitTestCase
{
    /**
     * @var ContainsPasswordConfirmation
     */
    protected $trait;

    /**
     * Initialize Trait
     */
    public function setUp(): void
    {
        $this->trait = new class
        {
            use ContainsPasswordConfirmation;
        };
    }

    /**
     * @test
     */
    public function mutatorWorksProperly(): void
    {
        $password = 'secret';

        $this->trait->setPasswordConfirmation($password);

        $this->assertSame($password, $this->trait->getPasswordConfirmation());
    }
}
