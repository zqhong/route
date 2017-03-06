<?php

namespace Zqhong\Route\Test;

use PHPUnit\Framework\TestCase;
use Zqhong\Route\Route;
use Zqhong\Route\RouteParser;

class RouteParserTest extends TestCase
{
    /**
     * @dataProvider provideTestParse
     * @param string $routeStr
     * @param $handler
     * @param array $expectedRouteData
     */
    public function testParse($routeStr, $handler, $expectedRouteData)
    {
        $parser = new RouteParser();
        $routeData = $parser->parse($routeStr, $handler);
        $this->assertEquals($expectedRouteData, $routeData);
    }

    public function provideTestParse()
    {
        return [
            [
                '/login',
                'login',
                new Route('/login', 'login', []),
            ],
            [
                '/user/{id:\d+}',
                'getUser',
                new Route('/user/(\d+)', 'getUser', ['id' => 'id']),
            ],
            [
                '/article/{id:\d+}/{offset:\d+}/{limit:\d+}',
                'getArticle',
                new Route('/article/(\d+)/(\d+)/(\d+)', 'getArticle', [
                    'id' => 'id',
                    'offset' => 'offset',
                    'limit' => 'limit',
                ]),
            ],
            [
                '/error/[#]',
                'error',
                new Route('/error/[#]', 'error', []),
            ]
        ];
    }
}
