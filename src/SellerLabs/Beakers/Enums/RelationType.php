<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Enums;

use SellerLabs\Beakers\Enum;

/**
 * Class RelationType
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Enums
 */
class RelationType extends Enum
{
    const HAS_ONE = 'hasOne';
    const HAS_MANY = 'hasMany';
    const HAS_MANY_THROUGH = 'hasManyThrough';
    const BELONGS_TO = 'belongsTo';
    const BELONGS_TO_MANY = 'belongsToMany';
}
