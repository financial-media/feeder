<?php

namespace FM\Feeder\Item\Transformer;

use Symfony\Component\HttpFoundation\ParameterBag;

class StringToBooleanTransformer implements DataTransformerInterface
{
    /**
     * @var array
     */
    protected $defaultTruthyValues = array(
        'true',
        'yes',
        'on',
    );

    /**
     * @var array
     */
    protected $defaultFalsyValues = array(
        'false',
        'no',
        'off',
    );

    /**
     * @var array
     */
    protected $truthyValues;

    /**
     * @var array
     */
    protected $falsyValues;

    /**
     * @param array   $truthy
     * @param array   $falsy
     * @param boolean $merge
     */
    public function __construct(array $truthy = array(), array $falsy = array(), $merge = true)
    {
        if (empty($truthy)) {
            $truthy = $this->defaultTruthyValues;
        } elseif ($merge) {
            $truthy = array_merge($this->defaultTruthyValues, $truthy);
        }

        if (empty($falsy)) {
            $falsy = $this->defaultFalsyValues;
        } elseif ($merge) {
            $falsy = array_merge($this->defaultFalsyValues, $falsy);
        }

        $this->truthyValues = array_map('mb_strtolower', $truthy);
        $this->falsyValues  = array_map('mb_strtolower', $falsy);
    }

    public function transform($value, $key, ParameterBag $item)
    {
        // only transform when we have something to transform
        if (is_null($value)) {
            return $value;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (in_array(mb_strtolower($value), $this->truthyValues)) {
            return true;
        }

        if (in_array(mb_strtolower($value), $this->falsyValues)) {
            return false;
        }

        return (boolean) $value;
    }
}
