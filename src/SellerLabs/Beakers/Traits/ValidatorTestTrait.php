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

use SellerLabs\Beakers\Validator;

/**
 * Class ValidatorTestTrait.
 *
 * Required properties
 *
 * @property array $validData a list of valid values that should succeed
 * @property array $invalidData a list of invalid values that should fail
 * @method Validator make()
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers\Traits
 */
trait ValidatorTestTrait
{
    public function testSuccess()
    {
        $validator = $this->make();

        $this->assertTrue(
            $validator->validate($this->validData),
            $validator->getMessages()->toJson()
        );
    }

    public function testFailure()
    {
        $validator = $this->make();
        // Test the top level of validation rules
        $this->failEachOnce($this->validData, $this->invalidData, $validator);

        // Test the sub validators
        foreach ($validator->getSubValidators() as $key => $validator) {
            $subValid = $this->validData[$key];
            $subInvalid = $this->invalidData[$key];
            if (isset($subValid[0])) {
                foreach ($subValid as $i => $foo) {
                    $this->failEachOnce(
                        $subValid[$i],
                        $subInvalid[$i],
                        $validator
                    );
                }
            } else {
                $this->failEachOnce(
                    $subValid,
                    $subInvalid,
                    $validator
                );
            }
        }
    }

    /**
     * Fail each field individually
     *
     * @param array $valid
     * @param array $invalid
     * @param Validator $validator
     */
    protected function failEachOnce($valid, $invalid, Validator $validator)
    {
        foreach ($invalid as $field => $value) {
            $data = array_except($valid, $field);
            $data[$field] = $value;
            $this->assertFalse(
                $validator->validate($data),
                $field . ': ' . print_r($value, true)
            );
            $this->assertTrue(
                $validator->getMessages()->has($field),
                $field . ' should fail'
            );
        }
    }
}
