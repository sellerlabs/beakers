<?php

/**
 * Copyright 2016, SellerLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the SellerLabs package
 */

namespace Tests\SellerLabs\Beakers\Support;

use Illuminate\Support\Str;
use SellerLabs\Beakers\Support\Entity;

/**
 * Class SampleEntity
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 *
 * @package Tests\SellerLabs\Beakers\Support
 */
class SampleEntity extends Entity
{
    protected $fillable = ['last_name', 'age', 'pin'];

    protected $hidden = ['pin'];

    protected $visible = ['first_name'];

    protected $firstName;

    protected $pin;

    protected $age;

    protected $lastName;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param integer $pin
     */
    public function setPin($pin)
    {
        $this->pin = (int) $pin;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = (int) $age;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return Str::studly($this->lastName);
    }
}