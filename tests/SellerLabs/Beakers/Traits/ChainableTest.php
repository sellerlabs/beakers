<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace Tests\Tests\SellerLabs\Beakers\Traits;

use SellerLabs\Beakers\Traits\Chainable;
use stdClass;
use Tests\SellerLabs\Beakers\TestCase;

/**
 * Class ChainableTest
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package Tests\SellerLabs\Beakers\Traits
 */
class ChainableTest extends TestCase
{
    protected $traitName = Chainable::class;

    public function testChain()
    {
        $mock = $this->makeTrait();

        $obj = new stdClass();
        $obj->wasCalled = false;
        $this->assertEquals(
            $mock,
            $mock->chain(
                function () use ($obj) {
                    $obj->wasCalled = true;
                }
            )
        );

        $this->assertTrue($obj->wasCalled);
    }
}
