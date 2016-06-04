<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers;

use Illuminate\Support\ServiceProvider;

/**
 * Class GenericServiceProvider
 *
 * Base class for service providers that just bind a bunch of interfaces
 * to implementations.
 *
 * @property string $namespace
 * @property array $provisions
 *
 * @package SellerLabs\Beakers
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
abstract class GenericServiceProvider extends ServiceProvider
{
    protected $bindings;

    /**
     * Construct a new GenericServiceProvider.
     *
     * If $provisions and $namespace are set, $namespace should be the the one
     * the main service class is located in, and $provisions should consist
     * of the names of any services in that directory that need to be bound.
     *
     * Example:
     *
     * If we have:
     *
     * My\Namespaced\ExampleClass
     *
     * and
     *
     * My\Namespaced\Interfaces\ExampleClassInterface
     *
     * then the following assignments would automatically bind the interface
     * to the implementation in My\Namespaced\ExampleServiceProvider:
     *
     * protected $namespace = __NAMESPACE__;
     * protected $provisions = ['ExampleClass'];
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        if (isset($this->provisions) && isset($this->namespace)) {
            foreach ($this->provisions as $provision) {
                $baseNamespace = $this->namespace . "\\";
                $interface = $baseNamespace
                    . "Interfaces\\"
                    . $provision . "Interface";

                $class = $baseNamespace
                    . $provision;

                $this->bindings[$interface] = $class;
            }
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        foreach ($this->getBindings() as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }

    /**
     * @return array a list of interface/client pairs
     */
    protected function getBindings()
    {
        return $this->bindings;
    }

    /**
     * Provide a list of services provided.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->getBindings());
    }
}
