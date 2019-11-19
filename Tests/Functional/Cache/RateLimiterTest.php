<?php
declare(strict_types = 1);

namespace LMS\Login\Tests\Functional\Cache;

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

use LMS\Login\Cache\RateLimiter;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class RateLimiterTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/login'];

    /**
     * @test
     */
    public function can_be_created(): void
    {
        $this->assertNotEmpty(RateLimiter::make());
    }

    /**
     * @test
     */
    public function cache_initialized(): void
    {
        $reflector = new \ReflectionClass(RateLimiter::class);

        $cache = $reflector->getProperty('cache');
        $cache->setAccessible(true);

        $this->assertNotEmpty($cache->getValue(RateLimiter::make()));
    }

    /**
     * @test
     */
    public function release_timer_is_set_properly_when_decay_is_zero(): void
    {
        $key = 'my_key';
        $limiter = RateLimiter::make();

        $limiter->hit($key, 0);

        $this->assertSame(0, $limiter->availableIn($key));
    }

    /**
     * @test
     */
    public function timer_can_be_reset(): void
    {
        $key = 'my_key';
        $limiter = RateLimiter::make();

        $limiter->hit($key);
        $limiter->clear($key);

        $this->assertSame(0, $limiter->availableIn($key));
    }

    /**
     * @test
     */
    public function release_timer_is_set_properly(): void
    {
        $key = 'my_key';
        $limiter = RateLimiter::make();

        $limiter->hit($key);

        $this->assertSame(60, $limiter->availableIn($key));
    }

    /**
     * @test
     */
    public function not_existing_cache_key_has_zero_attempts(): void
    {
        $this->assertSame(0, RateLimiter::make()->attempts('my_key'));
    }

    /**
     * @test
     */
    public function existing_cache_key_accumulates_attempts(): void
    {
        $key = 'my_key';
        $limiter = RateLimiter::make();

        $limiter->hit($key);
        $limiter->hit($key);

        $this->assertSame(2, $limiter->attempts($key));
    }

    /**
     * @test
     */
    public function attempts_can_be_reset_to_zero(): void
    {
        $key = 'my_key';
        $limiter = RateLimiter::make();

        $limiter->hit($key);

        $resetCompletedSuccessfully = $limiter->resetAttempts($key);

        $this->assertTrue($resetCompletedSuccessfully);
        $this->assertSame(0, $limiter->attempts($key));
    }

    /**
     * @test
     */
    public function attempts_can_not_be_reset_when_key_invalid(): void
    {
        $this->assertFalse(
            RateLimiter::make()->resetAttempts('not_defined_cache_key')
        );
    }

    /**
     * @test
     */
    public function attempts_are_not_locked_when_cache_key_invalid(): void
    {
        $this->assertFalse(
            RateLimiter::make()->tooManyAttempts('not_defined_cache_key', 1)
        );
    }

    /**
     * @test
     */
    public function max_attempts_can_be_reached(): void
    {
        $key = 'my_key';
        $maxAttemptsCount = 2;
        $limiter = RateLimiter::make();

        $limiter->hit($key);

        $this->assertFalse(
            $limiter->tooManyAttempts($key, $maxAttemptsCount)
        );

        $limiter->hit($key);

        $this->assertTrue(
            $limiter->tooManyAttempts($key, $maxAttemptsCount)
        );
    }
}
