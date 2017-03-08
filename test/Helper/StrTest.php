<?php

namespace Zqhong\Route\Test\Helper;

use PHPUnit\Framework\TestCase;
use Zqhong\Route\Helpers\Str;

class StrTest extends TestCase
{
    public function testContains()
    {
        $this->assertSame(true, Str::contains('hello', 'h'));
        $this->assertSame(true, Str::contains('hello', 'he'));
        $this->assertSame(false, Str::contains('hello', 'fo'));

        $this->assertSame(false, Str::contains('hello', ''));

        $this->assertSame(true, Str::contains('你好', '好'));
        $this->assertSame(false, Str::contains('你好', '不'));
    }
}
