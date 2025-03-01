<?php

declare(strict_types=1);

namespace Ramsey\Http\Range\Test\Unit;

use Mockery;
use Mockery\MockInterface;
use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Unit\AbstractUnit;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use Ramsey\Http\Range\Unit\UnitRangesCollection;

class AbstractUnitTest extends TestCase
{
    protected AbstractUnit & MockInterface $unit;

    protected function setUp(): void
    {
        $this->unit = Mockery::mock(
            AbstractUnit::class,
            [
                '500-999,1500-',
                '10000',
            ],
            [
                'getRangeUnit' => 'foobar',
            ],
        )->makePartial();

        $this->unit
            ->shouldReceive('newCollection')
            ->andReturn(new UnitRangesCollection());

        $this->unit
            ->shouldReceive('newRange')
            ->andReturn(Mockery::mock(UnitRangeInterface::class));
    }

    public function testGetRangeSet(): void
    {
        $this->assertSame('500-999,1500-', $this->unit->getRangeSet());
    }

    public function testGetRangesSpecifier(): void
    {
        $this->assertSame('foobar=500-999,1500-', $this->unit->getRangesSpecifier());
    }

    public function testGetTotalSize(): void
    {
        $this->assertSame('10000', $this->unit->getTotalSize());
    }

    public function testGetRanges(): void
    {
        $ranges = $this->unit->getRanges();

        $this->assertCount(2, $ranges);
    }
}
