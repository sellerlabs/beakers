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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use SellerLabs\Beakers\Exceptions\NotSoftDeletingTraitException;

/**
 * Class Finder
 *
 * Wraps Eloquent ActiveRecords for the sake of finding single models in the
 * database with easy mocking capabilities.
 *
 * @package SellerLabs\Beakers\Interfaces
 * @author Benjamin Kovach <benjamin@roundsphere.com>
 */
interface FinderInterface
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     *
     * @return \Illuminate\Support\Collection|Model|null
     */
    public function find($id, $columns = ['*']);

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
    public function findOrFail($id, $columns = ['*']);

    /**
     * Make sure the finder also checks for trashed items
     *
     * @param bool|true $withTrashed
     *
     * @return $this
     * @throws NotSoftDeletingTraitException
     */
    public function withTrashed($withTrashed = true);

    /**
     * Add a basic where clause to a finder query
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @param  string  $boolean
     *
     * @return Builder
     */
    public function where(
        $column,
        $operator = null,
        $value = null,
        $boolean = 'and'
    );
}
