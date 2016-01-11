<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Exceptions;

use Exception;

/**
 * Class DeprecatedException.
 *
 * An exception to throw when deciding to deprecate a method, keep track of
 * the version number to identify when a reasonable time has passed before
 * removing the method
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Exceptions
 */
class DeprecatedException extends Exception
{
    /**
     * DeprecatedException constructor.
     *
     * @param string $method
     * @param string $class
     * @param string $version
     */
    public function __construct($method, $class, $version)
    {
        parent::__construct(
            sprintf(
                'The %s method in the %s class is deprecated since version %s',
                $method,
                $class,
                $version
            )
        );
    }
}
