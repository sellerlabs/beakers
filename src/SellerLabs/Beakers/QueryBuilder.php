<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace SellerLabs\Beakers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Quip\Expressions\Expression;
use SellerLabs\Beakers\Interfaces\QueryBuilderInterface;
use SellerLabs\Beakers\Traits\Chainable;

/**
 * Class QueryBuilder
 *
 * Base class for building queries for various models
 *
 * @property $model
 *
 * @package SellerLabs\Beakers
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
abstract class QueryBuilder implements QueryBuilderInterface
{
    use Chainable;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Construct a new query builder from a model and a name of the collection
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Eager load a relation.
     *
     * @param $relation
     *
     * @return $this
     */
    public function with($relation)
    {
        $this->query->with($relation);

        return $this;
    }

    /**
     * Return the query.
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Search a column
     *
     * @param string $column The column sto search
     * @param string $search The search value
     * @param bool|true $lhs Whether to wildcard on the left
     * @param bool|true $rhs Whether to wildcard on the right
     *
     * @return $this
     */
    public function like($column, $search, $lhs = true, $rhs = true)
    {
        if ($lhs) {
            $search = '%' . $search;
        }

        if ($rhs) {
            $search = $search . '%';
        }

        $this->query->where(function (Builder $query) use ($column, $search) {
            return $query->where(
                $column,
                'LIKE',
                $search
            );
        });

        return $this;
    }

    /**
     * Get the results from the query that has been built and reset it.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get()
    {
        $ret = $this->query->get();
        $this->reset();

        return $ret;
    }

    /**
     * Filter down based on a dynamic Quip expression
     *
     * @param Expression $expression
     *
     * @return $this
     */
    public function dynamicExpression(Expression $expression)
    {
        $this->query->where(
            $expression->getLhs(),
            $expression->getOperator(),
            $expression->getRhs()
        );

        return $this;
    }

    /**
     * Paginate a result set and reset the query.
     *
     * @param {int} $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate($limit)
    {
        $ret = $this->query->paginate($limit);
        $this->reset();

        return $ret;
    }

    /**
     * Start creating a new query
     *
     * @return $this
     */
    public function reset()
    {
        /** @var Eloquent $model */
        $model = $this->model;

        $this->query = $model::query();

        return $this;
    }

    /**
     * Return the number of results.
     *
     * @return integer
     */
    public function count()
    {
        return $this->query()->count();
    }

    /**
     * Use an existing query to build off of.
     *
     * @param Builder $query
     *
     * @return QueryBuilder
     */
    public function setQuery(Builder $query)
    {
        $this->query = $query;

        return $this;
    }
}
