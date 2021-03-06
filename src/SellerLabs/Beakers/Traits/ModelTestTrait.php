<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use SellerLabs\Beakers\Enums\RelationType;

/**
 * Trait ModelTestTrait.
 *
 * @method Model make()
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Traits
 */
trait ModelTestTrait
{
    /**
     * Assert the the model defines a HasOne relationship.
     *
     * @param Model $model
     * @param string $property
     * @param string $other
     */
    protected function assertHasOne($model, $property, $other)
    {
        $this->assertHasRelation(
            HasOne::class,
            $model,
            $property,
            $other
        );
    }

    /**
     * Assert the the model defines a HasMany relationship.
     *
     * @param Model $model
     * @param string $property
     * @param string $other
     */
    protected function assertHasMany($model, $property, $other)
    {
        $this->assertHasRelation(
            HasMany::class,
            $model,
            $property,
            $other
        );
    }

    /**
     * Assert the the model defines a HasManyThrough relationship.
     *
     * @param Model $model
     * @param string $property
     * @param string $other
     */
    protected function assertHasManyThrough($model, $property, $other)
    {
        $this->assertHasRelation(
            HasManyThrough::class,
            $model,
            $property,
            $other
        );
    }

    /**
     * Assert the the model defines a BelongsTo relationship.
     *
     * @param Model $model
     * @param string $property
     * @param string $other
     */
    protected function assertBelongsTo($model, $property, $other)
    {
        $this->assertHasRelation(
            BelongsTo::class,
            $model,
            $property,
            $other
        );
    }

    /**
     * Assert the the model defines a BelongsToMany relationship.
     *
     * @param Model $model
     * @param string $property
     * @param string $other
     */
    protected function assertBelongsToMany($model, $property, $other)
    {
        $this->assertHasRelation(
            BelongsToMany::class,
            $model,
            $property,
            $other
        );
    }

    /**
     * Assert the the model defines a given relationship.
     *
     * @param string $relationClass
     * @param Model $model
     * @param string $property
     * @param string $other
     */
    protected function assertHasRelation(
        $relationClass,
        $model,
        $property,
        $other
    ) {
        $this->assertTrue(method_exists($model, $property));

        /** @var HasManyThrough $relation */
        $relation = $model->$property();

        $this->assertInstanceOf($relationClass, $relation);
        $this->assertInstanceOf($other, $relation->getRelated());
    }

    /**
     * Return a list of relations to be tested.
     *
     * @return array
     */
    abstract public function relationsProvider();

    /**
     * Checks if all relations are covered.
     */
    public function testAllRelationsCovered()
    {
        $relations = $this->relationsProvider();
        $model = $this->make()->getRelations();
        $this->assertEquals(
            count($model),
            count($relations),
            implode(
                ',',
                array_diff(
                    $model,
                    array_map(
                        function ($relation) {
                            return $relation[0];
                        },
                        $relations
                    )

                )
            ) . ' missing'
        );
    }

    /**
     * Tests relationship definitions.
     *
     * @param string $property
     * @param string $type
     * @param string $other
     *
     * @dataProvider relationsProvider
     */
    public function testRelations($property, $type, $other)
    {
        $model = $this->make();

        $this->assertContains(
            $property,
            $model->getRelations(),
            "[{$property}] not defined in [" . $this->className . ']'
        );

        switch ($type) {
            case RelationType::HAS_ONE:
                $this->assertHasOne($model, $property, $other);
                break;
            case RelationType::HAS_MANY:
                $this->assertHasMany($model, $property, $other);
                break;
            case RelationType::HAS_MANY_THROUGH:
                $this->assertHasManyThrough($model, $property, $other);
                break;
            case RelationType::BELONGS_TO:
                $this->assertBelongsTo($model, $property, $other);
                break;
            case RelationType::BELONGS_TO_MANY:
                $this->assertBelongsToMany($model, $property, $other);
                break;
        }
    }

    /**
     * Tests relationship are connected to correct tables through correct keys.
     *
     * @param string $property
     * @param string $type
     * @param string $other
     *
     * @dataProvider relationsProvider
     */
    public function testRelationCanLoad($property, $type, $other)
    {
        $model = $this->make();

        switch ($type) {
            case RelationType::HAS_ONE:
            case RelationType::BELONGS_TO:
                $this->assertTrue(
                    is_null($model->$property)
                    || $model->$property instanceof $other
                );
                break;
            case RelationType::HAS_MANY:
            case RelationType::HAS_MANY_THROUGH:
            case RelationType::BELONGS_TO_MANY:
                $this->assertTrue($model->$property instanceof Collection);
                break;
        }
    }
}
