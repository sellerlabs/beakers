<?php

/**
 * Copyright 2014-2016, SellerLabs <snagshout-devs@sellerlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Snagshout package
 */

namespace SellerLabs\Beakers\Enums;

use SellerLabs\Beakers\Enum;

/**
 * Class VersionBumpType.
 *
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 * @package SellerLabs\Snagshout\Console\Enums
 */
class VersionBumpType extends Enum
{
    const MINOR = 'minor';
    const MAJOR = 'major';
    const PATCH = 'patch';
}
