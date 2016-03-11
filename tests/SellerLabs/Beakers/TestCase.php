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
}
