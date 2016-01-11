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

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

/**
 * Class ServiceProviderTestTrait
 *
 * @method ServiceProvider make()
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Traits
 */
trait ServiceProviderTestTrait
{


    public function testRegister()
    {
        $instance = $this->make();

        $instance->register();
        $shouldBeBound = $instance->provides();

        foreach ($shouldBeBound as $abstract) {
            $this->assertTrue(
                $this->mockApp->bound($abstract),
                "Class " . $abstract . " is not bound."
            );
        }

        // Reversely we want all service provider tests expect the bindings
        // they have
        $namespace = (new ReflectionClass($this->className))
            ->getNamespaceName();
        $keys = array_keys($this->mockApp->getBindings());
        array_walk(
            $keys,
            function ($bound) use ($namespace, $shouldBeBound) {
                if (stristr($bound, $namespace)) {
                    $this->assertContains(
                        $bound,
                        $shouldBeBound,
                        'Class ' . $bound . ' was bound, but not expected'
                    );
                }
            }
        );
    }

    public function testProvides()
    {
        $instance = $this->make();

        $result = $instance->provides();

        $this->assertInternalType('array', $result);
    }
}
