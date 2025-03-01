<?php

declare(strict_types=1);

namespace Ramsey\Http\Range\Test\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Unit\GenericUnit;

use function count;

class GenericUnitTest extends TestCase
{
    /**
     * @param list<array{start: int, end: int}> $expectedRanges
     */
    #[DataProvider('validValuesProvider')]
    public function testValidRangeValues(string $unitName, string $rangesString, int $size, array $expectedRanges): void
    {
        $unit = new GenericUnit($unitName, $rangesString, $size);
        $ranges = $unit->getRanges();

        $this->assertEquals($unitName, $unit->getRangeUnit());
        $this->assertCount(count($expectedRanges), $ranges);

        for ($i = 0; $i < count($ranges); $i++) {
            if (!isset($ranges[$i])) {
                $this->fail("The range value at $i is not set");
            }
            $this->assertEquals($expectedRanges[$i]['start'], $ranges[$i]->getStart());
            $this->assertEquals($expectedRanges[$i]['end'], $ranges[$i]->getEnd());
        }
    }

    /**
     * @return list<array{string, string, int, list<array{start: int, end: int}>}>
     */
    public static function validValuesProvider(): array
    {
        return [
            ['items', '0-499', 1000, [['start' => 0, 'end' => 499]]],
            ['items', '0-499', 200, [['start' => 0, 'end' => 199]]],
            ['foo', '40-80', 1000, [['start' => 40, 'end' => 80]]],
            ['foo', '-400', 1000, [['start' => 600, 'end' => 999]]],
            ['bar', '400-', 1000, [['start' => 400, 'end' => 999]]],
            ['bar', '0-', 1000, [['start' => 0, 'end' => 999]]],
            ['baz', '156', 1000, [['start' => 156, 'end' => 156]]],
            ['foobar', '0-0', 1000, [['start' => 0, 'end' => 0]]],
            ['foobar', '-1', 1000, [['start' => 999, 'end' => 999]]],
            [
                'foobar',
                '40-80,132,81-90,-1',
                1000,
                [
                    ['start' => 40, 'end' => 80],
                    ['start' => 132, 'end' => 132],
                    ['start' => 81, 'end' => 90],
                    ['start' => 999, 'end' => 999],
                ],
            ],
            [
                'foobar',
                '0-4,85,87,90-99,5-75,100-199,101-102',
                150,
                [
                    ['start' => 0, 'end' => 4],
                    ['start' => 85, 'end' => 85],
                    ['start' => 87, 'end' => 87],
                    ['start' => 90, 'end' => 99],
                    ['start' => 5, 'end' => 75],
                    ['start' => 100, 'end' => 149],
                    ['start' => 101, 'end' => 102],
                ],
            ],
            [
                'items',
                ' 0 - 199, 210-250 , 500- ',
                1000,
                [
                    ['start' => 0, 'end' => 199],
                    ['start' => 210, 'end' => 250],
                    ['start' => 500, 'end' => 999],
                ],
            ],
        ];
    }
}
