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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SellerLabs\Beakers\Exceptions\NotSoftDeletingTraitException;
use SellerLabs\Beakers\Interfaces\FinderInterface;

/**
 * Class Finder
 *
 * Wraps Eloquent ActiveRecords for the sake of finding single models in the
 * database with easy mocking capabilities.
 *
 * @package SellerLabs\Beakers
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
abstract class Finder implements FinderInterface
{
    /** @var  Model|SoftDeletes */
    protected $model;

    /**
     * @var bool
     */
    protected $withTrashed = false;

    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     *
     * @return \Illuminate\Support\Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $model = $this->model;

        if ($this->withTrashed) {
            $this->withTrashed = false;

            return $model::withTrashed()->find($id, $columns);
        }

        return $model::find($id, $columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     *
     * @return \Illuminate\Support\Collection|Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $model = $this->model;

        if ($this->withTrashed) {
            $this->withTrashed = false;

            return $model::withTrashed()->findOrFail($id, $columns);
        }

        return $model::findOrFail($id, $columns);
    }

    /**
     * Add a basic where clause to a finder query
     *
     * @param  string $column
     * @param  string $operator
     * @param  mixed $value
     * @param  string $boolean
     *
     * @return Builder
     */
    public function where(
        $column,
        $operator = null,
        $value = null,
        $boolean = 'and'
    ) {
        $model = $this->model;

        if ($this->withTrashed) {
            $this->withTrashed = false;

            return $model::withTrashed()
                ->where($column, $operator, $value, $boolean);
        }

        return $model::query()
            ->where($column, $operator, $value, $boolean);
    }

    /**
     * Make sure the finder also checks for trashed items
     *
     * @param bool|true $withTrashed
     *
     * @return $this
     * @throws NotSoftDeletingTraitException
     */
    public function withTrashed($withTrashed = true)
    {
        if (!in_array(SoftDeletes::class, class_uses($this->model))) {
            throw new NotSoftDeletingTraitException();
        }

        $this->withTrashed = $withTrashed;

        return $this;
    }
}
