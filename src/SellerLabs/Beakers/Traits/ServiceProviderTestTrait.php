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

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use SellerLabs\Beakers\Exceptions\NotImplementedException;

/**
 * Class ServiceProviderTestTrait
 *
 * @property Application $app
 * @property string $className
 * @method ServiceProvider make()
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Traits
 */
trait ServiceProviderTestTrait
{
       /**
     * Make an instance of the service provider being tested.
     *
     * @throws NotImplementedException
     * @return ServiceProvider
     */
    public function make()
    {
        if ($this->className) {
            $class = $this->className;

            return new $class($this->app);
        }

        throw new NotImplementedException(
            'className is not set: overload `make` or set the className property.'
        );
    }

    public function testRegister()
    {
        $instance = $this->make();

        $instance->register();
        $shouldBeBound = $instance->provides();

        foreach ($shouldBeBound as $abstract) {
            $this->assertTrue(
                $this->app->bound($abstract),
                "Class " . $abstract . " is not bound."
            );
        }

        // Reversely we want all service provider tests expect the bindings
        // they have
        $namespace = (new ReflectionClass($this->className))
            ->getNamespaceName();
        $keys = array_keys($this->app->getBindings());
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
