<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace Tests\SellerLabs\Beakers;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package Tests\SellerLabs\Beakers
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|mixed
     */
    protected function makeTrait()
    {
        return $this->getMockForTrait($this->traitName);
    }

    /**
     * Run assert equals with an input matrix.
     *
     * Every entry should be formatted as following:
     *
     * [$expected, $equals, $message (optional)]
     *
     * @param array $comparisons
     *
     * @throws InvalidArgumentException
     */
    public static function assertEqualsMatrix(array $comparisons)
    {
        $total = count($comparisons);

        foreach ($comparisons as $index => $comparison) {
            if (count($comparison) < 2) {
                throw new InvalidArgumentException(
                    'Comparison entry is invalid.'
                );
            }

            if (array_key_exists(2, $comparison)) {
                $message = $comparison[2];
            } else {
                $message = vsprintf(
                    'Comparison %d (of %d) is expected to be equal.',
                    [$index + 1, $total]
                );
            }

            static::assertEquals(
                $comparison[0],
                $comparison[1],
                $message
            );
        }
    }

}
