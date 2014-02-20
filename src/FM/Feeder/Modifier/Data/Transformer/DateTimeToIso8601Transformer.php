<?php

namespace FM\Feeder\Modifier\Data\Transformer;

use FM\Feeder\Exception\TransformationFailedException;

class DateTimeToIso8601Transformer implements TransformerInterface
{
    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (!$value instanceof \DateTime) {
            throw new TransformationFailedException(
                sprintf('Expected a DateTime to transform, got "%s" instead.', json_encode($value))
            );
        }

        return $value->format('c');
    }
}
