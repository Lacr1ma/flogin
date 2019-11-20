<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Domain\Model;

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

use LMS\Login\Domain\Model\Resets;
use LMS3\Support\Extbase\{ExtensionHelper, TypoScriptConfiguration};
use LMS3\Lms3access\Checker\PageAccessChecker;
use LMS3\Support\Model\AbstractModel;
use LMS3\Support\ObjectManageable;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface as Configuration;
use TYPO3\CMS\Core\Core\Bootstrap;
//
///**
// * @author Borulko Sergey <borulkosergey@icloud.com>
// */
//class ResetsTest extends \Nimut\TestingFramework\TestCase\FunctionalTestCase
//{
//    /**
//     * @var array
//     */
//    protected $testExtensionsToLoad = ['typo3conf/ext/login'];
//
//    /**
//     * @test
//     */
//    public function reset_link_life_time_defined(): void
//    {
//        $ts = TypoScriptConfiguration::getConfigurationManager()
//            ->getConfiguration(Configuration::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
//        $this->assertSame([1], $ts);
//    }
//}
