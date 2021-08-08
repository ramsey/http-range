<?php

declare(strict_types=1);

namespace Ramsey\Http\Range\Test;

use Ramsey\Http\Range\Exception\InvalidRangeSetException;
use Ramsey\Http\Range\Exception\InvalidRangeUnitException;
use Ramsey\Http\Range\Unit\BytesUnit;
use Ramsey\Http\Range\Unit\GenericUnit;
use Ramsey\Http\Range\UnitFactory;

class UnitFactoryTest extends TestCase
{
    public function testGetUnitReturnsBytesUnit(): void
    {
        $factory = new UnitFactory();

        $this->assertInstanceOf(BytesUnit::class, $factory->getUnit('bytes=30-100', 1000));
    }

    public function testGetUnitReturnsGenericUnit(): void
    {
        $factory = new UnitFactory();
        $unit = $factory->getUnit('items=30-100', 1000);

        $this->assertInstanceOf(GenericUnit::class, $unit);
        $this->assertEquals('items', $unit->getRangeUnit());
    }

    public function testGetUnitThrowsInvalidRangeUnitExceptionWhenNoRangeUnitProvided(): void
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeUnitException::class);
        $this->expectExceptionMessage('No range-unit provided in $rangesSpecifier');

        $factory->getUnit('=30-100', 1000);
    }

    public function testGetUnitThrowsInvalidRangeSetExceptionWhenNoRangeSetProvided(): void
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeSetException::class);
        $this->expectExceptionMessage('No range-set provided in $rangesSpecifier');

        $factory->getUnit('items=', 1000);
    }

    public function testGetUnitThrowsInvalidRangeUnitExceptionWhenNoValueProvided(): void
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeUnitException::class);
        $this->expectExceptionMessage('No range-unit provided in $rangesSpecifier');

        $factory->getUnit('', 1000);
    }

    public function testGetUnitThrowsInvalidRangeUnitExceptionWhenOnlyDelimiterProvided(): void
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeUnitException::class);
        $this->expectExceptionMessage('No range-unit provided in $rangesSpecifier');

        $factory->getUnit('=', 1000);
    }
}
