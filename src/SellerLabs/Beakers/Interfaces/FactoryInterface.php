<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface FactoryInterface
 *
 * Allows easy creation of models
 *
 * @package SellerLabs\Beakers\Interfaces
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
interface FactoryInterface
{
    /**
     * Save the instance
     *
     * @return mixed
     */
    public function save();

    /**
     * Get the instance of the model being built.
     *
     * @return Model
     */
    public function getInstance();
}
