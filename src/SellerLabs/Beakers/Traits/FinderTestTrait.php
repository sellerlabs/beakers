<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Traits;

use SellerLabs\Beakers\Interfaces\FinderInterface;

/**
 * Trait FinderTestTrait.
 *
 * @property string $model
 * @property string $className
 * @method FinderInterface make()
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Traits
 */
trait FinderTestTrait
{
    public function testConstructor()
    {
        $finder = $this->make();

        $this->assertInstanceOf(FinderInterface::class, $finder);
    }

    public function testHasFinderMethods()
    {
        $this->assertTrue(
            method_exists($this->className, 'find')
        );

        $this->assertTrue(
            method_exists($this->className, 'findOrFail')
        );
    }

    public function testModelIsSet()
    {
        $this->assertTrue(
            property_exists($this->className, 'model')
        );

        $this->assertEquals(
            $this->model,
            $this->readAttribute(app($this->className), 'model')
        );
    }

}
