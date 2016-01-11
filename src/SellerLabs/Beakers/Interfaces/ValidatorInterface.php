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

/**
 * Class Validator
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers
 */
interface ValidatorInterface
{
    /**
     * Validate the values
     *
     * @param array $values
     *
     * @return bool
     */
    public function validate(array $values);

    /**
     * Get error messages when the validator fails
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getMessages();
}
