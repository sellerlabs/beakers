<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Hashing;

/**
 * Class HmacHasher.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 *
 * @package SellerLabs\Beakers\Hashing
 */
class HmacHasher
{
    /**
     * Algorithm to use for hashing.
     *
     * @var string
     */
    protected $algorithm;

    /**
     * Construct a new instance of a HmacHasher.
     *
     * @param string $algorithm
     */
    public function __construct($algorithm = 'sha512')
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Get a list of supported hashing algorithms.
     *
     * @return array
     */
    public static function getAlgorithms()
    {
        return hash_algos();
    }

    /**
     * Generate a hash of the content using the provided private key.
     *
     * @param string $content
     * @param string $privateKey
     *
     * @return string
     */
    public function hash($content, $privateKey)
    {
        return hash_hmac($this->algorithm, $content, $privateKey);
    }

    /**
     * Verify that a hash is valid.
     *
     * @param string $hash
     * @param string $content
     * @param string $privateKey
     *
     * @return bool
     */
    public function verify($hash, $content, $privateKey)
    {
        return $this->hash($content, $privateKey) === $hash;
    }
}
