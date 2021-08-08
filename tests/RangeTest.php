<?php

declare(strict_types=1);

namespace Ramsey\Http\Range\Test;

use Mockery;
use Psr\Http\Message\RequestInterface;
use Ramsey\Http\Range\Exception\NoRangeException;
use Ramsey\Http\Range\Range;
use Ramsey\Http\Range\Unit\UnitInterface;
use Ramsey\Http\Range\UnitFactory;
use Ramsey\Http\Range\UnitFactoryInterface;

class RangeTest extends TestCase
{
    private Range $range;
    private RequestInterface $request;
    private int $size;
    private UnitInterface $unit;
    private UnitFactoryInterface $unitFactory;

    protected function setUp(): void
    {
        $rangeHeader = ['bytes=100-200'];

        $this->size = 1000;
        $this->unit = Mockery::mock(UnitInterface::class);

        $this->request = Mockery::mock(RequestInterface::class);
        $this->request->shouldReceive('getHeader')->with('Range')->andReturn($rangeHeader);

        $this->unitFactory = Mockery::mock(UnitFactoryInterface::class);
        $this->unitFactory->shouldReceive('getUnit')->with($rangeHeader[0], $this->size)->andReturn($this->unit);

        $this->range = new Range($this->request, $this->size, $this->unitFactory);
    }

    public function testGetRequest(): void
    {
        $this->assertSame($this->request, $this->range->getRequest());
    }

    public function testGetTotalSize(): void
    {
        $this->assertSame($this->size, $this->range->getTotalSize());
    }

    public function testGetUnitFactory(): void
    {
        $this->assertSame($this->unitFactory, $this->range->getUnitFactory());
    }

    public function testConstructorCreatesNewUnitFactory(): void
    {
        $range = new Range($this->request, $this->size);

        $this->assertInstanceOf(UnitFactory::class, $range->getUnitFactory());
        $this->assertNotSame($this->unitFactory, $range->getUnitFactory());
    }

    public function testGetUnit(): void
    {
        $this->assertSame($this->unit, $this->range->getUnit());
    }

    public function testGetUnitThrowExceptionWhenNoRangeFound(): void
    {
        $request = Mockery::mock(RequestInterface::class);
        $request->shouldReceive('getHeader')->with('Range')->andReturn([]);

        $range = new Range($request, $this->size, $this->unitFactory);

        $this->expectException(NoRangeException::class);
        $this->expectExceptionMessage('The Range header is not present on this request or has no value');

        $range->getUnit();
    }
}
