<?php

namespace Zqhong\Route\Test\Helper;

use PHPUnit\Framework\TestCase;
use Zqhong\Route\Helpers\Arr;

class ArrTest extends TestCase
{
    public function testGetValue()
    {
        $testArr = [
            'a' => 1,
            'b' => [
                'c' => 2,
                'd' => [
                    'e' => 3,
                    'f' => [
                        'g' => 4,
                    ]
                ]
            ]
        ];

        $this->assertSame(1, Arr::getValue($testArr, 'a'));
        $this->assertSame(2, Arr::getValue($testArr, 'b.c'));
        $this->assertSame(3, Arr::getValue($testArr, 'b.d.e'));
        $this->assertSame(4, Arr::getValue($testArr, 'b.d.f.g'));

        $this->assertSame('', Arr::getValue($testArr, 'NOT_FOUND_KEY', ''));
    }
}