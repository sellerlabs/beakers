<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Support;

use Ds\Set;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Class Entity
 *
 * An entity provides some of the functionality of Laravel Model classes but
 * without being strictly related to databases. Entities are most commonly used
 * for serializing and deserializing data from an API.
 *
 * Entities use setters and getter dynamically when they are available. If they
 * are not, the value is set directly. You may use getters and setters to
 * validate data (PHP 7 type hints or manual checks) or to transform it.
 *
 * Additionally, Entities allow one to define three sets of properties:
 * fillable, visible, and hidden. When the fillable set is not null, only
 * properties mention in such set will be allowed in the fill() method. The
 * remaining two affect the behavior of toArray().
 *
 * For entity properties that are dynamically computed by a getter, and not
 * stored in a property, one can include it in the visible set. This tells the
 * toArray() method to also include that property even if its not really a
 * class property. Likewise, the hidden set allows one to filter and remove
 * properties from the output of toArray().
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 *
 * @package SellerLabs\Beakers\Support
 */
abstract class Entity implements
    Arrayable
{
    /**
     * Define which properties can be "filled" using an input array.
     *
     * When set to `null`, the entity is considered to not declare any fillable
     * fields, which will cause an exception to be thrown if a fill operation
     * is attempted on the entity.
     *
     * To declare that there are no fields that can be filled, use an empty
     * array ([]).
     *
     * @var null|string[]
     */
    protected $fillable = null;

    /**
     * Get which fields should be hidden from serialization, such as toArray().
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get which fields should be included in serialization.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * Fill properties in this object using an input array.
     *
     * - Only fields that are mentioned in the fillable array can be set.
     * - Other keys will just be ignored completely.
     * - If a setter is present, it will be automatically called.
     *
     * @param array $input
     *
     * @return $this
     */
    public function fill(array $input)
    {
        $this->assertIsFillable();

        foreach (array_only($input, $this->getFillable()) as $key => $value) {
            $setter = vsprintf('set%s', [Str::studly($key)]);

            if (method_exists($this, $setter)) {
                $this->$setter($value);

                continue;
            }

            $camel = Str::camel($key);
            $this->$camel = $value;
        }

        return $this;
    }

    /**
     * Assert that this entity can be filled.
     *
     * @throws InvalidArgumentException
     */
    protected function assertIsFillable()
    {
        if ($this->getFillable() === null) {
            throw new InvalidArgumentException(
                'Unable to fill an entity that has not declared which'
                . ' properties are fillable.'
            );
        }
    }

    /**
     * Get which fields should be allowed to be filled.
     *
     * @return null|string[]
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Get which fields should be included in serialization.
     *
     * @return array
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Get an array representation of this entity.
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];

        $keys = new Set();

        $keys->add(...$this->getFillable());
        $keys->add(...$this->getVisible());

        $keys->remove(...$this->getHidden());

        foreach ($keys as $key) {
            $getter = vsprintf('get%s', [Str::studly($key)]);

            if (method_exists($this, $getter)) {
                $result[$key] = $this->$getter();

                continue;
            }

            $camel = Str::camel($key);
            $result[$key] = $this->$camel;
        }

        return $result;
    }

    /**
     * Get which fields should not be included during serialization.
     *
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}
