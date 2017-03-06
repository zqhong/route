<?php

namespace Zqhong\Route\Test;

use PHPUnit\Framework\TestCase;
use Zqhong\Route\Route;
use Zqhong\Route\RouteGenerator;

class RouteGeneratorTest extends TestCase
{
    /**
     * @dataProvider provideCombineVarRoutes
     * @param array $varRoutes
     * @param array $exceptedRouteData
     */
    public function testCombineVarRoutes($varRoutes, $exceptedRouteData)
    {
        $routeGenerator = new RouteGenerator();
        $routeData = $routeGenerator->combineVarRoutes($varRoutes);
        $this->assertEquals($exceptedRouteData, $routeData);
    }

    public function provideCombineVarRoutes()
    {
        return [
            [
                [
                    new Route('/user/(\d+)', 'getUser', ['id' => 'id']),
                    new Route('/article/(\d+)', 'getArticle', ['id' => 'id']),
                ],
                [
                    'regex' => '~^(?|/user/(\d+)|/article/(\d+)())$~',
                    'routeMap' => [
                        2 => [
                            'handler' => 'getUser',
                            'params' => ['id' => 'id'],
                        ],
                        3 => [
                            'handler' => 'getArticle',
                            'params' => ['id' => 'id']
                        ]
                    ],
                ]
            ],
        ];
    }
}