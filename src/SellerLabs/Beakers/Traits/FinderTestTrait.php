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

/**
 * Trait FinderTestTrait.
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Traits
 */
trait FinderTestTrait
{
    protected $model;

    /**
     * Test that the finder has the right methods
     */
    public function testHasFinderMethods()
    {
        $this->assertTrue(
            method_exists($this->className, 'find')
        );

        $this->assertTrue(
            method_exists($this->className, 'findOrFail')
        );
    }

    /**
     * Test that the finder has the right model associated
     */
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
