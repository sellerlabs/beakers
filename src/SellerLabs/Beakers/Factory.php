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

use Illuminate\Database\Eloquent\Model as Eloquent;
use SellerLabs\Beakers\Interfaces\FactoryInterface;

/**
 * Class Factory
 *
 * Allows easy creation of models
 *
 * @package SellerLabs\Beakers
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
class Factory implements FactoryInterface
{
    /**
     * Fully qualified name of the class to create an instance of
     *
     * @var string
     */
    protected $model;

    /**
     * Instance of the model to be created
     *
     * @var Eloquent
     */
    protected $instance;

    /**
     * Construct a new Factory instance
     */
    public function __construct()
    {
        $model = $this->model;
        $this->instance = new $model();
    }

    /**
     * Save the instance
     *
     * @return mixed
     */
    public function save()
    {
        return $this->instance->save();
    }

    /**
     * Get the instance of the model being built
     *
     * @return Eloquent
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
