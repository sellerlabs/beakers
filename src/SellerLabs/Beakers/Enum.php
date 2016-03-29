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

use ReflectionClass;

/**
 * Class Enum
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package SellerLabs\Snagshout\Support
 */
abstract class Enum
{
    /**
     * Get all enumerables (constants) from this Enum.
     *
     * @return array
     */
    public static function getConstants()
    {
        $self = new ReflectionClass(static::class);

        return $self->getConstants();
    }

    /**
     * Get the value of a single constant.
     *
     * @param $constant
     *
     * @return mixed
     */
    public static function getConstant($constant)
    {
        $self = new ReflectionClass(static::class);

        return $self->getConstant($constant);
    }

    /**
     * Check weather the value is part of this enum.
     *
     * @param $value
     *
     * @return bool
     */
    public static function isValueValid($value)
    {
        return in_array($value, self::getConstants());
    }

    /**
     * Returns the values as a laravel validation rule.
     *
     * @return string
     */
    public static function validationRule()
    {
        return 'in:'. implode(',', static::getConstants());
    }
}
