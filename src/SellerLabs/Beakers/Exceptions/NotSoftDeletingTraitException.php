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
 * Class NotSoftDeletingTraitException
 *
 * Thrown when someone tries to use a finder withTrashed
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Exceptions
 */
class NotSoftDeletingTraitException extends Exception
{
    protected $message = 'This model is not a soft deleting model';
}
