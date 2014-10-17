<?php

namespace FM\Feeder\Tests\Resource\Transformer;

use FM\Feeder\Resource\ResourceCollection;
use FM\Feeder\Resource\StringResource;
use FM\Feeder\Resource\Transformer\RemoveControlCharactersTransformer;

class RemoveControlCharactersTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTestData
     */
    public function testTransform($from, $to)
    {
        $resource = new StringResource($from);
        $coll = new ResourceCollection([$resource]);
        $coll->addTransformer(new RemoveControlCharactersTransformer(1));

        $file = $coll->current()->getFile()->getPathname();

        $this->assertSame($to, file_get_contents($file));
    }

    public static function getTestData()
    {
        return [
            [
                sprintf('Stripping null bytes%s, unit separators%s, and vertical tabs%s', chr(0), chr(31), chr(11)),
                'Stripping null bytes, unit separators, and vertical tabs'
            ],
            [
                sprintf("While stripping control%s characters%s...\n\nnewlines and\ttabs are kept intact", chr(26), chr(127)),
                "While stripping control characters...\n\nnewlines and\ttabs are kept intact"
            ],
            [
                sprintf("Also%s, mültîb¥†é characters%s do not break", chr(7), chr(27)),
                "Also, mültîb¥†é characters do not break"
            ]
        ];
    }
}
