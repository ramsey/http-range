<?php
namespace Ramsey\Http\Range\Test\Unit;

use Ramsey\Http\Range\Test\TestCase;
use Ramsey\Http\Range\Unit\BytesUnit;

class BytesUnitTest extends TestCase
{
    /**
     * @dataProvider validValuesProvider
     */
    public function testValidRangeValues($rangesString, $size, $expectedRanges)
    {
        $bytes = new BytesUnit($rangesString, $size);
        $ranges = $bytes->getRanges();

        $this->assertEquals('bytes', $bytes->getRangeUnit());
        $this->assertCount(count($expectedRanges), $ranges);

        for ($i = 0; $i < count($ranges); $i++) {
            $this->assertEquals($expectedRanges[$i]['start'], $ranges[$i]->getStart());
            $this->assertEquals($expectedRanges[$i]['end'], $ranges[$i]->getEnd());
        }
    }

    public function validValuesProvider()
    {
        return [
            ['0-499', 1000, [['start' => 0, 'end' => 499]]],
            ['0-499', 200, [['start' => 0, 'end' => 199]]],
            ['40-80', 1000, [['start' => 40, 'end' => 80]]],
            ['-400', 1000, [['start' => 600, 'end' => 999]]],
            ['400-', 1000, [['start' => 400, 'end' => 999]]],
            ['0-', 1000, [['start' => 0, 'end' => 999]]],
            ['0-0', 1000, [['start' => 0, 'end' => 0]]],
            ['-1', 1000, [['start' => 999, 'end' => 999]]],
            ['136', 1000, [['start' => 136, 'end' => 136]]],
            ['40-80,81-90,273,-1', 1000, [
                ['start' => 40, 'end' => 80],
                ['start' => 81, 'end' => 90],
                ['start' => 273, 'end' => 273],
                ['start' => 999, 'end' => 999],
            ]],
            ['0-4,85,87,90-99,5-75,100-199,101-102', 150, [
                ['start' => 0, 'end' => 4],
                ['start' => 85, 'end' => 85],
                ['start' => 87, 'end' => 87],
                ['start' => 90, 'end' => 99],
                ['start' => 5, 'end' => 75],
                ['start' => 100, 'end' => 149],
                ['start' => 101, 'end' => 102],
            ]],
        ];
    }
}
