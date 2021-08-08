<?php

declare(strict_types=1);

namespace Ramsey\Http\Range\Test\Unit;

use InvalidArgumentException;
use Mockery;
use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Unit\BytesRange;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use Ramsey\Http\Range\Unit\UnitRangesCollection;
use stdClass;

class UnitRangesCollectionTest extends TestCase
{
    public function testUnitRangesCollection(): void
    {
        $ranges = [
            Mockery::mock(UnitRangeInterface::class),
            Mockery::mock(UnitRangeInterface::class),
            Mockery::mock(UnitRangeInterface::class),
            Mockery::mock(UnitRangeInterface::class),
            Mockery::mock(BytesRange::class),
            Mockery::mock(BytesRange::class),
        ];

        $collection = new UnitRangesCollection();

        foreach ($ranges as $range) {
            $collection[] = $range;
        }

        $this->assertCount(6, $collection);
    }

    public function testUnitRangesCollectionThrowsException(): void
    {
        $collection = new UnitRangesCollection();

        $this->expectException(InvalidArgumentException::class);

        $collection[] = new stdClass(); // @phpstan-ignore-line
    }
}
