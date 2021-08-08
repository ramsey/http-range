<?php

namespace Ramsey\Http\Range\Test\Unit;

use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Unit\BytesRange;
use Ramsey\Http\Range\Unit\BytesRangesCollection;
use Ramsey\Http\Range\Unit\UnitRangeInterface;

class BytesRangesCollectionTest extends TestCase
{
    public function testBytesRangesCollection()
    {
        $ranges = [
            \Mockery::mock(BytesRange::class),
            \Mockery::mock(BytesRange::class),
            \Mockery::mock(BytesRange::class),
            \Mockery::mock(BytesRange::class),
        ];

        $collection = new BytesRangesCollection();

        foreach ($ranges as $range) {
            $collection[] = $range;
        }

        $this->assertCount(4, $collection);
    }

    public function testBytesRangesCollectionThrowsException()
    {
        $collection = new BytesRangesCollection();

        $this->expectException(\InvalidArgumentException::class);

        $collection[] = \Mockery::mock(UnitRangeInterface::class);
    }
}
