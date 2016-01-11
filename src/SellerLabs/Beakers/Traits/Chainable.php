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
 * Class Chainable
 *
 * Represents a class that can chain calls (call a function, then return $this).
 *
 * @package SellerLabs\Snagshout\Common\Traits
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
trait Chainable
{
    /**
     * Chain a `callable` function, and return $this
     *
     * @param callable $next
     *
     * @return $this
     */
    public function chain(callable $next)
    {
        $next();

        return $this;
    }
}
