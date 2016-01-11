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

use Illuminate\Validation\Factory;
use SellerLabs\Beakers\Interfaces\ValidatorInterface;

/**
 * Class Validator
 *
 * @author Mark Vaughn <mark@roundsphere.com>
 * @package SellerLabs\Beakers
 */
abstract class Validator implements ValidatorInterface
{
    protected $rules = [];

    /**
     * @var array keys that should not be set
     */
    protected $forbiddenKeys = [];

    /**
     * The array of custom attribute names.
     *
     * @var array
     */
    protected $customAttributes = [];

    /**
     * The array of custom error messages.
     *
     * @var array
     */
    protected $customMessages = [];

    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * @var Validator[]
     */
    protected $subValidators = [];

    /**
     * Validate the values
     *
     * @param array $values
     *
     * @return bool
     */
    public function validate(array $values)
    {
        $values = $this->snakeArrayKeys($values);

        $this->validator = $this->make(
            $values,
            $this->getRules()
        );

        // Make sure any forbidden keys are reported
        foreach ($this->forbiddenKeys as $key) {
            if (array_key_exists($key, $values)) {
                $this->addErrorMessage(
                    $key,
                    sprintf('%s should not be set', $key)
                );

                return false;
            }
        }

        $passes = $this->validator->passes();

        // Validate the sub rules
        foreach ($this->getSubValidators() as $key => $validator) {
            // Skip missing data, if it were required the require rule would
            // kick in
            if (!isset($values[$key])) {
                continue;
            }

            $subValues = $values[$key];
            if (count($subValues)) {
                // If the 0 index is set it means we have multiple sub
                // objects to validate
                if (isset($subValues[0])) {
                    foreach ($subValues as $subValueSet) {
                        /** @var Validator $validator */
                        $validator = new $validator();
                        $passes = $passes
                            && $this->subValidate(
                                $validator,
                                $subValueSet,
                                $key
                            );
                    }
                } else {
                    /** @var Validator $validator */
                    $validator = new $validator();
                    $passes = $passes
                        && $this->subValidate($validator, $subValues, $key);
                }
            }
        }

        return $passes;
    }

    /**
     * Get error messages when the validator fails
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getMessages()
    {
        return $this->validator->getMessageBag();
    }

    /**
     * @param array $values
     * @param array $rules
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function make(array $values, array $rules)
    {
        return $this->getFactory()->make(
            $values,
            $rules,
            $this->customMessages,
            $this->customAttributes
        );
    }

    /**
     * Converts keys of an array to snake_case
     *
     * @param array $array
     *
     * @return array
     */
    protected function snakeArrayKeys(array $array)
    {
        $return = [];

        foreach ($array as $key => $value) {
            $return[snake_case($key)] = $value;
        }

        return $return;
    }

    /**
     * Get any array of sub validators
     *
     * @return Validator[]
     */
    public function getSubValidators()
    {
        $return = [];

        foreach ($this->subValidators as $key => $class) {
            $return[$key] = new $class();
        }

        return $return;
    }

    /**
     * Run a sub-validator and merge messages into the error messages
     *
     * @param Validator $validator
     * @param $values
     * @param $key
     *
     * @return bool
     */
    protected function subValidate(Validator $validator, $values, $key)
    {
        if ($validator->validate($values)) {
            return true;
        }

        $this->getMessages()->merge($validator->getMessages());

        $this->addErrorMessage(
            $key,
            'There was an error with the  subset of data'
        );

        return false;
    }

    /**
     * Add an error message to the validator
     *
     * @param string $field
     * @param string $message
     *
     * @return $this
     */
    protected function addErrorMessage($field, $message)
    {
        $this->getMessages()
            ->add($field, $message);

        return $this;
    }

    /**
     * Get the validation rules
     *
     * @return array
     */
    protected function getRules()
    {
        return $this->rules;
    }

    /**
     * @return Factory
     */
    protected function getFactory()
    {
        return app(Factory::class);
    }
}
