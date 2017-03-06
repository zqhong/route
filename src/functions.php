<?php

use Zqhong\Route\RouteCollector;
use Zqhong\Route\RouteDispatcher;
use Zqhong\Route\RouteGenerator;
use Zqhong\Route\RouteParser;

if (!function_exists('dispatcher')) {
    function dispatcher(callable $callback, array $options = [])
    {
        $options += [
            'routeParser' => RouteParser::class,
            'routeGenerator' => RouteGenerator::class,
            'dispatcher' => RouteDispatcher::class,
            'routeCollector' => RouteCollector::class,
        ];

        $routeCollector = new $options['routeCollector'](
            new $options['routeParser'], new $options['routeGenerator']
        );
        $callback($routeCollector);

        return new $options['dispatcher']($routeCollector);
    }
}