<?php

use zqhong\route\RouteCollector;
use zqhong\route\RouteDispatcher;
use zqhong\route\RouteGenerator;
use zqhong\route\RouteParser;

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
