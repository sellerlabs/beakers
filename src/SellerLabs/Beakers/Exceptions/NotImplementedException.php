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
 * Class NotImplementedException
 *
 * Thrown when a method is not yet implemented.
 *
 * @package SellerLabs\Beakers\Exceptions
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
class NotImplementedException extends Exception
{
    protected $message = 'Method was not implemented';
}
