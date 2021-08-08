<?php

declare(strict_types=1);

namespace Ramsey\Http\Range\Test\Unit;

use Mockery;
use Ramsey\Http\Range\Exception\NotSatisfiableException;
use Ramsey\Http\Range\Exception\ParseException;
use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Test\Unit\Mock\MockUnitRange;
use Ramsey\Http\Range\Unit\AbstractUnitRange;

class AbstractUnitRangeTest extends TestCase
{
    public function testConstructorThrowsParseExceptionWhenRangeIsEmpty(): void
    {
        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('Unable to parse range: ');

        Mockery::mock(AbstractUnitRange::class, ['', '10000']);
    }

    public function testConstructorThrowsParseExceptionWhenBothSidesAreEmpty(): void
    {
        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('Unable to parse range: -');

        Mockery::mock(AbstractUnitRange::class, ['-', '10000']);
    }

    public function testConstructorThrowsParseExceptionWhenMoreThanTwoValues(): void
    {
        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('Unable to parse range: 1-2-3');

        Mockery::mock(AbstractUnitRange::class, ['1-2-3', '10000']);
    }

    public function testConstructorThrowsNotSatisfiableExceptionWhenSuffixByteRangeSpecLengthIsZero(): void
    {
        $e = null;

        try {
            Mockery::mock(AbstractUnitRange::class, ['-0', '10000']);
        } catch (NotSatisfiableException $e) {
            // Perform assertions on exception below; we're using this pattern
            // so we can perform assertions on the additional exception methods
            // added to NotSatisfiableException.
        }

        $this->assertInstanceOf(NotSatisfiableException::class, $e);
        $this->assertEquals('Unable to satisfy range: -0; length is zero', $e->getMessage());
        $this->assertEquals('-0', $e->getRange());
        $this->assertEquals('10000', $e->getTotalSize());
    }

    public function testConstructorThrowsNotSatisfiableExceptionWhenStartIsGreaterThanSize(): void
    {
        $e = null;

        try {
            Mockery::mock(AbstractUnitRange::class, ['10001-', '10000']);
        } catch (NotSatisfiableException $e) {
            // Perform assertions on exception below; we're using this pattern
            // so we can perform assertions on the additional exception methods
            // added to NotSatisfiableException.
        }

        $this->assertInstanceOf(NotSatisfiableException::class, $e);
        $this->assertEquals(
            'Unable to satisfy range: 10001-; start (10001) is greater than size (10000)',
            $e->getMessage(),
        );
        $this->assertEquals('10001-', $e->getRange());
        $this->assertEquals('10000', $e->getTotalSize());
    }

    public function testConstructorThrowsParseExceptionWhenEndIsLessThanStart(): void
    {
        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('The end value cannot be less than the start value: 9999-500');

        Mockery::mock(AbstractUnitRange::class, ['9999-500', '10000']);
    }

    /**
     * @dataProvider validRangeValuesProvider
     */
    public function testValidRangeValues(
        string $range,
        int $size,
        int $expectedStart,
        int $expectedEnd,
        int $expectedLength
    ): void {
        $unitRange = new MockUnitRange($range, $size);

        $this->assertEquals($range, $unitRange->getRange());
        $this->assertEquals($size, $unitRange->getTotalSize());
        $this->assertEquals($expectedStart, $unitRange->getStart());
        $this->assertEquals($expectedEnd, $unitRange->getEnd());
        $this->assertEquals($expectedLength, $unitRange->getLength());
    }

    /**
     * @return mixed[]
     */
    public function validRangeValuesProvider(): array
    {
        return [
            ['0-499', 1000, 0, 499, 500],
            ['0-499', 200, 0, 199, 200],
            ['40-80', 1000, 40, 80, 41],
            ['-400', 1000, 600, 999, 400],
            ['400-', 1000, 400, 999, 600],
            ['0-', 1000, 0, 999, 1000],
            ['0-0', 1000, 0, 0, 1],
            ['-1', 1000, 999, 999, 1],
            ['136', 1000, 136, 136, 1],
        ];
    }
}
