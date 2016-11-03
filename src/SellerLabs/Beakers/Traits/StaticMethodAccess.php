<?php

/**
 * Copyright 2014-2016, SellerLabs <snagshout-devs@sellerlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Snagshout package
 */

namespace SellerLabs\Beakers\Traits;

use SellerLabs\Beakers\Exceptions\NotImplementedException;

/**
 * Trait StaticMethodAccess.
 *
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 * @package SellerLabs\Snagshout\Common\Traits
 */
trait StaticMethodAccess
{
    /**
     * Get the method name from Laravel's perspective.
     *
     * @param string $name
     *
     * @throws NotImplementedException
     * @return string
     */
    public static function method($name)
    {
        if (!method_exists(static::class, $name)) {
            throw new NotImplementedException(
                'Method ' . $name . ' does not exist in class ' . static::class
            );
        }

        return static::class . '@' . $name;
    }
}
