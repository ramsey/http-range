<?php
namespace Ramsey\Http\Range\Test;

use Ramsey\Http\Range\Exception\InvalidRangeSetException;
use Ramsey\Http\Range\Exception\InvalidRangeUnitException;
use Ramsey\Http\Range\UnitFactory;
use Ramsey\Http\Range\Unit\BytesUnit;
use Ramsey\Http\Range\Unit\GenericUnit;

class UnitFactoryTest extends TestCase
{
    public function testGetUnitReturnsBytesUnit()
    {
        $factory = new UnitFactory();

        $this->assertInstanceOf(BytesUnit::class, $factory->getUnit('bytes=30-100', 1000));
    }

    public function testGetUnitReturnsGenericUnit()
    {
        $factory = new UnitFactory();
        $unit = $factory->getUnit('items=30-100', 1000);

        $this->assertInstanceOf(GenericUnit::class, $unit);
        $this->assertEquals('items', $unit->getRangeUnit());
    }

    public function testGetUnitThrowsInvalidRangeUnitExceptionWhenNoRangeUnitProvided()
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeUnitException::class);
        $this->expectExceptionMessage('No range-unit provided in $rangesSpecifier');

        $factory->getUnit('=30-100', 1000);
    }

    public function testGetUnitThrowsInvalidRangeSetExceptionWhenNoRangeSetProvided()
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeSetException::class);
        $this->expectExceptionMessage('No range-set provided in $rangesSpecifier');

        $factory->getUnit('items=', 1000);
    }

    public function testGetUnitThrowsInvalidRangeUnitExceptionWhenNoValueProvided()
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeUnitException::class);
        $this->expectExceptionMessage('No range-unit provided in $rangesSpecifier');

        $factory->getUnit('', 1000);
    }

    public function testGetUnitThrowsInvalidRangeUnitExceptionWhenOnlyDelimiterProvided()
    {
        $factory = new UnitFactory();

        $this->expectException(InvalidRangeUnitException::class);
        $this->expectExceptionMessage('No range-unit provided in $rangesSpecifier');

        $factory->getUnit('=', 1000);
    }
}
