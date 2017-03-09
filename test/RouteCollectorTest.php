<?php

namespace zqhong\route\Test;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use zqhong\route\Route;
use zqhong\route\RouteCollector;
use zqhong\route\RouteGenerator;
use zqhong\route\RouteParser;

class RouteCollectorTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testAddStaticRoute()
    {
        $httpMethod = 'http';
        $route = '/user/1';
        $handler = 'getUser';

        $routeInstance = new Route($route, $handler, []);
        $routeParser = m::mock(RouteParser::class);
        $routeParser->shouldReceive('parse')->times(1)->andReturn($routeInstance);

        $routeGenerator = m::mock(RouteGenerator::class);

        $routeCollector = new RouteCollector($routeParser, $routeGenerator);
        $routeCollector->addRoute($httpMethod, $route, $handler);

        $this->assertEquals([
            $httpMethod => [
                $route => $handler
            ]
        ], $routeCollector->getStaticRoutes());
    }

    public function testAddVariableRoute()
    {
        $httpMethod = 'http';
        $route = '/user/{id:\d+}';
        $handler = 'getUser';

        $routeInstance = new Route('/user/(\d+)', $handler, ['id' => 'id']);
        $routeParser = m::mock(RouteParser::class);
        $routeParser->shouldReceive('parse')->times(1)->andReturn($routeInstance);

        $routeGenerator = m::mock(RouteGenerator::class);

        $routeCollector = new RouteCollector($routeParser, $routeGenerator);
        $routeCollector->addRoute($httpMethod, $route, $handler);

        $this->assertEquals([
            $httpMethod => [
                $routeInstance
            ]
        ], $routeCollector->getVariableRoutes());
    }

    public function testGetCombinedVarRoutes()
    {
        $excepted = [
            'regex' => '~^(?|/user/(\d+)|/article/(\d+)())$~',
            'routeMap' => [
                2 => ['handler' => 'getUser', 'params' => ['id' => 'id']],
                3 => ['handler' => 'getArticle', 'params' => ['id' => 'id']]
            ]
        ];


        $route1 = '/user/{id:\d+}';
        $handler1 = 'getUser';
        $params1 = ['id' => 'id'];
        $route2 = '/article/{id:\d+}';
        $handler2 = 'getArticle';
        $params2 = ['id' => 'id'];


        $routeParser = m::mock(RouteParser::class);
        $routeParser->shouldReceive('parse')->times(2)->andReturn(new Route($route1, $handler1, $params1), new Route($route2, $handler2, $params2));

        $routeGenerator = m::mock(RouteGenerator::class);
        $routeGenerator->shouldReceive('combineVarRoutes')->andReturn($excepted);

        $routeCollector = new RouteCollector($routeParser, $routeGenerator);
        $routeCollector->addRoute('get', '/user/{id:\d+}', 'getUser');
        $routeCollector->addRoute('get', '/article/{id:\d+}', 'getArticle');

        $this->assertEquals($excepted, $routeCollector->getCombinedVarRoutes('get'));
    }

    public function testGetEmptyCombinedVarRoutes()
    {
        $routeParser = m::mock(RouteParser::class);
        $routeGenerator = m::mock(RouteGenerator::class);

        $routeCollector = new RouteCollector($routeParser, $routeGenerator);

        $this->assertSame(false, $routeCollector->getCombinedVarRoutes('GET'));
    }
}
