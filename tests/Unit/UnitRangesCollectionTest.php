<?php

namespace Ramsey\Http\Range\Test\Unit;

use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Unit\BytesRange;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use Ramsey\Http\Range\Unit\UnitRangesCollection;

class UnitRangesCollectionTest extends TestCase
{
    public function testUnitRangesCollection()
    {
        $ranges = [
            \Mockery::mock(UnitRangeInterface::class),
            \Mockery::mock(UnitRangeInterface::class),
            \Mockery::mock(UnitRangeInterface::class),
            \Mockery::mock(UnitRangeInterface::class),
            \Mockery::mock(BytesRange::class),
            \Mockery::mock(BytesRange::class),
        ];

        $collection = new UnitRangesCollection();

        foreach ($ranges as $range) {
            $collection[] = $range;
        }

        $this->assertCount(6, $collection);
    }

    public function testUnitRangesCollectionThrowsException()
    {
        $collection = new UnitRangesCollection();

        $this->expectException(\InvalidArgumentException::class);

        $collection[] = new \stdClass();
    }
}
