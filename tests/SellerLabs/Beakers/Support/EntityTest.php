<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace Tests\SellerLabs\Beakers\Support;

use InvalidArgumentException;
use Mockery;
use SellerLabs\Beakers\Support\Entity;
use Tests\SellerLabs\Beakers\TestCase;

/**
 * Class EntityTest
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 *
 * @package Tests\SellerLabs\Beakers\Support
 */
class EntityTest extends TestCase
{
    public function testFill()
    {
        $instance = new SampleEntity();

        $instance->setFirstName('Bobby');

        $instance->fill([
            'last_name' => 'tables',
            'age' => '34',
            'pin' => 1337
        ]);

        $this->assertEquals([
            'first_name' => 'Bobby',
            'last_name' => 'Tables',
            'age' => 34,
        ], $instance->toArray());
    }

    public function testFillWithUndeclared()
    {
        $this->expectException(InvalidArgumentException::class);

        $instance = Mockery::mock(Entity::class);

        $instance->shouldDeferMissing();

        /** @var Entity $instance */
        $instance->fill([]);
    }
}